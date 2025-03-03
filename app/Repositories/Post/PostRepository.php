<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Data\PostData;

class PostRepository
{
    public function all()
    {
        return Post::all();
    }

    public function findById($id)
    {
        return Post::find($id);
    }

    public function create(PostData $postData)
    {
        // Attach multiple users (array of user IDs)
        $post = Post::create($postData->toArray());
        $post->users()->attach(1);

        return $post;
    }

    public function update(Post $post, PostData $postData)
    {
        $post->update($postData->toArray());

        return $post;
    }

    public function delete($id)
    {
        return Post::destroy($id);
    }

    public function getPostsByUser($userId)
    {
        return Post::where('user_id', $userId)->get();
    }
}
