<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function index($postId)
    {
        $comments = Comment::with('user.profile')
            ->where('post_id', $postId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'string|nullable',
            'media.*' => 'file|mimes:jpeg,jpg,png,gif,mp4,avi,mkv|max:10240', // 10MB Max
        ]);

        try {
            $mediaPaths = [];
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('media', 'public');
                    $mediaPaths[] = $path;
                }
            }

            $comment = new Comment([
                'post_id' => $request->post_id,
                'user_id' => Auth::id(),
                'content' => $request->get('content'),
                'media' => json_encode($mediaPaths),
            ]);

            $comment->save();

            return response()->json($comment, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar comentário: ' . $e->getMessage());
            return response()->json(['error' => 'Falha ao criar o comentário. Por favor, tente novamente.'], 400);
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            if ($comment->user_id !== Auth::id()) {
                return response()->json(['error' => 'Você não tem permissão para deletar este comentário.'], 403);
            }

            $comment->delete();

            return response()->json(['message' => 'Comentário deletado com sucesso.'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar comentário: ' . $e->getMessage());
            return response()->json(['error' => 'Falha ao deletar o comentário. Por favor, tente novamente.'], 400);
        }
    }
}
