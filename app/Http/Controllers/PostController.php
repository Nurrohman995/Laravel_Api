<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Post;
use Auth;
Use App\Transformers\PostTransformer;

class PostController extends Controller
{
    public function add(Request $request, Post $post)
    {
        $this->validate($request, [
            'content' => "required|min:10",
        ]);

        $post = $post->create([
            'user_id' => Auth::user()->id,
            'content' => $request->content,
        ]);

        $response = fractal()
                ->item($post)
                ->TransformWith(new PostTransformer)
                ->toArray();
        return response()->json($response, 201);
    }
}
