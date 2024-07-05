<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function getPosts()
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
        $posts = Post::with(['user.profile', 'likes'])
            ->whereIn('user_id', $friendIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->each(function ($post) use ($userId) {
                $post->user_liked = $post->likes->contains('user_id', $userId);
            });

        return response()->json($posts);
    }


    public function newPost(Request $request): \Illuminate\Http\JsonResponse
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

    public function removePostById(Post $post): \Illuminate\Http\JsonResponse
    {
        try {

            Log::info("Removing post object: " . $post->user_id);

            if ($post->user_id !== Auth::id()) {
                return response()->json(['error' => 'Você não tem permissão para deletar este post.'], 403);
            }

            $post->delete(); // Deletar o post

            Log::info("Post deleted");

            return response()->json(['message' => 'Post deletado com sucesso.'], 200);
        } catch (Exception $e) {
            Log::error('Erro ao deletar post: ' . $e->getMessage());
            return response()->json(['error' => 'Falha ao deletar o post. Por favor, tente novamente.'], 400);
        }
    }

    public function likePost($postId)
    {
        try {
            $post = Post::findOrFail($postId);

            $like = Like::firstOrCreate([
                'user_id' => Auth::id(),
                'post_id' => $postId,
            ]);

            $postOwnerId = $like->post->user_id;
            $userProfile = User::find(Auth::id())->profile;

            if ($postOwnerId !== Auth::id()) {
                Notification::createNotification($postOwnerId, 'like', [
                    'message' => $userProfile->name . ' curtiu seu post.',
                    'post_id' => $like->post_id,
                ]);
            }

            return response()->json(['message' => 'Post liked successfully.', 'likes_count' => $post->likes()->count()], 200);
        } catch (Exception $e) {
            Log::error('Erro ao dar like no post: ' . $e->getMessage());
            return response()->json(['error' => 'Falha ao dar like no post. Por favor, tente novamente.'], 400);
        }
    }

    public function unlikePost($postId)
    {
        try {
            $post = Post::findOrFail($postId);

            $like = Like::where([
                'user_id' => Auth::id(),
                'post_id' => $postId,
            ])->first();

            if ($like) {
                $like->delete();
                return response()->json(['message' => 'Post unliked successfully.', 'likes_count' => $post->likes()->count()], 200);
            } else {
                return response()->json(['error' => 'Você não deu like neste post.'], 400);
            }
        } catch (Exception $e) {
            Log::error('Erro ao tirar like no post: ' . $e->getMessage());
            return response()->json(['error' => 'Falha ao tirar like no post. Por favor, tente novamente.'], 400);
        }
    }



}
