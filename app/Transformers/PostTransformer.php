<?php

namespace App\Transformer;
Use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    public function Transform(Post $post)
    {
        return [
            'id'      => $post->id,
            'content' => $post->content,
            'publish' => $post->created_at->diffForHumans(),
        ];
    }
}
