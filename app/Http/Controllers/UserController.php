<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $loginField = $request->input('username');
        $password = $request->input('password');

        $credentials = [];
        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $loginField];
        } elseif (preg_match('/^[0-9]+$/', $loginField)) {
            $credentials = ['telefone' => $loginField];
        } else {
            $credentials = ['username' => $loginField];
        }

        $credentials['password'] = $password;

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
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:40',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password), // Encrypting the password with bcrypt
        ]);

        // Create the corresponding profile
        $profile = Profile::create([
            'user_id' => $user->id,
        ]);

        return redirect()->intended('login');
    }

    public function loggedUser()
    {
        $user = auth()->user();
        return response()->json($user);
    }

    public function index()
    {
        $users = User::all()->except(Auth::id());
        return response()->json($users);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
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

    public function destroy(string $id)
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
}
