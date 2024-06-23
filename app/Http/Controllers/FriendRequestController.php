<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

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

    public function acceptRequest($id): \Illuminate\Http\JsonResponse
    {
        try {
            $friendRequest = FriendRequest::findOrFail($id);

            // Verificar se o pedido já não foi aceito/rejeitado
            if ($friendRequest->status !== 'PENDING') {
                return response()->json(['message' => 'Friend request is not pending'], 400);
            }

            // Atualizar o status do pedido para 'ACCEPTED'
            $friendRequest->update(['status' => 'ACCEPTED']);

            Log::info("Aceitou ".$friendRequest);

            // Criar a amizade
            $friend = Friend::create([
                'user1_id' => $friendRequest->user_id,
                'user2_id' => $friendRequest->recipient_id,
                'status' => 'ACTIVE',
            ]);

            Log::info("Passou da cricação ".$friend);

            // Verificar se a amizade foi criada com sucesso
            if ($friend) {
                return response()->json(['message' => 'Friend request accepted successfully']);
            } else {
                return response()->json(['message' => 'Failed to create friendship'], 500);
            }
        } catch (Exception $e) {
            Log::error('Error accepting friend request: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
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
