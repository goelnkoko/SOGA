<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function sendRequest(Request $request) {
        $request->validate([
            'recipient_id' => 'required|exists:users,id'
        ]);

        if($request->recipient_id != Auth::id()){
            $friendRequest = FriendRequest::create([
                'user_id' => Auth::id(),
                'recipient_id' => $request->recipient_id,
                'status' => 'PENDING',
            ]);
            return response()->json(['message' => 'Friend request sent successfully', 'friendRequest' => $friendRequest], 201);
        }
        return response()->json(['message' => 'You are not allowed to send friend request'], 403);
    }


    public function acceptRequest($id) {
        $friendRequest = FriendRequest::findOrFail($id);
        $friendRequest->update(['status' => 'ACCEPTED']);

        //Criar amizade
        Friend::create([
            'user1_id' => $friendRequest->user_id,
            'user2_id' => $friendRequest->recipient_id,
            'status' => 'ACTIVE',
        ]);

        return response()->json(['message' => 'Friend request accepted successfully']);
    }

    public function rejectRequest($id)
    {
        $friendRequest = FriendRequest::findOrFail($id);
        $friendRequest->update(['status' => 'REJECTED']);

        return response()->json(['message' => 'Friend request rejected successfully']);
    }

    public function index()
    {
        $requests = FriendRequest::where('recipient_id', Auth::id())->with('user')->get();

        return response()->json($requests);
    }
}
