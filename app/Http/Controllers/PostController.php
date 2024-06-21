<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();
        return response()->json($posts);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
            'media.*' => 'file|mimes:jpeg,jpg,png,gif,mp4,avi,mkv|max:20480', // 20MB Max
        ]);

        try {
            $mediaPaths = [];
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $path = $file->store('media', 'public');
                    $mediaPaths[] = $path;
                }
            }

            $post = new Post([
                'content' => $request->get('content'),
                'user_id' => Auth::id(), // Associando o ID do usuário logado ao post
                'media' => json_encode($mediaPaths),
            ]);

            $post->save();

            return response()->json($post, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Falha ao criar o post. Por favor, tente novamente.'], 500);
        }
    }
}
