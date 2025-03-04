<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Data\PostData;
use Illuminate\Support\Collection;

class PostRepository
{
    public function all(): Collection
    {
        return Post::all();
    }

    public function findById($id): ?Post
    {
        return Post::find($id);
    }

    public function create(PostData $postData): Post
    {
        return Post::create($postData->toArray());
    }

    public function update(Post $post, PostData $postData): Post
    {
        $post->update($postData->toArray());
        return $post;
    }

    public function delete($id): bool
    {
        return Post::destroy($id);
    }
}
