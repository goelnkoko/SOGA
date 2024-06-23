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
        $friendships = Friend::where('user1_id', Auth::id())
            ->orWhere('user2_id', Auth::id())
            ->get();
        return response()->json($friendships);
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
}
