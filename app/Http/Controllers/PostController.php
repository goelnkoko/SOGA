<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function showPosts()
    {
        // Id do usuário logado
        $userId = auth()->id();

        // Buscar os IDs dos amigos do usuário logado
        $friendIds = Friend::where(function($query) use ($userId) {
            $query->where('user1_id', $userId)
                ->orWhere('user2_id', $userId);
        })->where('status', 'ACTIVE')
            ->get()
            ->map(function($friend) use ($userId) {
                return $friend->user1_id === $userId ? $friend->user2_id : $friend->user1_id;
            });

        // Incluir o ID do usuário logado na lista de IDs
        $friendIds[] = $userId;

        // Buscar posts dos amigos e do próprio usuário, ordenados por data de criação
        $posts = Post::with('user')
            ->whereIn('user_id', $friendIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
    }


    public function store(Request $request): \Illuminate\Http\JsonResponse
    {

        Log::info("Loading post creating 2");

        $request->validate([
            'content' => 'string',
            'media.*' => 'file|mimes:jpeg,jpg,png,gif,mp4,avi,mkv|max:10240', // 10MB Max
        ]);

        Log::info("Post request validated");

        try {
            $mediaPaths = [];
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('media', 'public');
                    $mediaPaths[] = $path;
                }
            }

            Log::info("Added images to media path");

            $post = new Post([
                'content' => $request->get('content'),
                'user_id' => Auth::id(), // Associando o ID do usuário logado ao post
                'media' => json_encode($mediaPaths),
            ]);

            Log::info("Created post object");

            $post->save();

            Log::info("Post saved");

            return response()->json($post, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Falha ao criar o post. Por favor, tente novamente.'], 400);
        }
    }
}
