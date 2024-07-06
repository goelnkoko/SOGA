<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(['username', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:40|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'birthdate' => 'required|date',
            'gender' => 'required|string|max:10',
            'location' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        // Criação do perfil
        $profile = Profile::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'location' => $request->location,
        ]);

        $defaultImagePath = public_path('assets/img/user.png');
        $newImagePath = 'photos/' . uniqid() . '.png';

        try {
            // Copiar a imagem padrão para o storage público
            Storage::disk('public')->put($newImagePath, file_get_contents($defaultImagePath));
            $profile->update(['photo' => $newImagePath]);
        } catch (\Exception $e) {
            Log::error("Erro ao copiar a imagem padrão: " . $e->getMessage());
        }

        return redirect()->intended('login');
    }

    public function loggedUser()
    {
        $user = auth()->user()->load('profile');
        return response()->json($user);
    }

    public function index()
    {
        $users = User::with('profile')->get()->except(Auth::id());
        return response()->json($users);
    }

    public function show(string $id)
    {
        $user = User::with('profile')->findOrFail($id);
        return response()->json($user);
    }


    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function deleteAccount(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function getNonFriends()
    {
        $authUserId = Auth::id();

        // Get friends
        $friends = Friend::where(function($query) use ($authUserId) {
            $query->where('user1_id', $authUserId)
                ->orWhere('user2_id', $authUserId);
        })->pluck('user1_id', 'user2_id')->toArray();

        // Get friend requests sent or received
        $friendRequests = FriendRequest::where(function($query) use ($authUserId) {
            $query->where('user_id', $authUserId)
                ->orWhere('recipient_id', $authUserId);
        })->pluck('user_id', 'recipient_id')->toArray();

        // Merge all ids
        $excludedUserIds = array_merge(
            array_keys($friends),
            array_values($friends),
            array_keys($friendRequests),
            array_values($friendRequests),
            [$authUserId] // Exclude the auth user itself
        );

        // Get users that are not friends, and have not sent or received friend requests
        $users = User::whereNotIn('id', $excludedUserIds)->with('profile')->get();

        return response()->json($users);
    }

    public function searchUsers(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $query = $request->input('query');
        $users = User::where('username', 'like', '%' . $query . '%')
            ->orWhereHas('profile', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->with('profile')
            ->get();

        return response()->json($users);
    }
}
