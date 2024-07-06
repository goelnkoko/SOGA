<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function getFriends()
    {
        $friendships = Friend::where(function ($query) {
            $query->where('user1_id', Auth::id())
                ->orWhere('user2_id', Auth::id());
        })->with(['user1.profile', 'user2.profile'])->get();

        $friends = $friendships->map(function ($friendship) {
            if ($friendship->user1_id === Auth::id()) {
                return $friendship->user2;
            } else {
                return $friendship->user1;
            }
        });

        return response()->json($friends);
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:ACTIVE,BLOCKED,SUSPENDED',
        ]);

        $friendship = Friend::findOrFail($id);
        $friendship->update(['status' => $request->status]);

        return response()->json(['message' => 'Friendship status updated successfully']);
    }

    public function removeFriend($id)
    {
        try {
            $friendship = Friend::findOrFail($id);

            // Verificar se o usuário autenticado faz parte da amizade
            if ($friendship->user1_id !== Auth::id() && $friendship->user2_id !== Auth::id()) {
                return response()->json(['message' => 'You are not authorized to remove this friendship'], 403);
            }

            $friendship->delete();

            return response()->json(['message' => 'Friendship removed successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
