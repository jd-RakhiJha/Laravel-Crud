<?php

namespace App\Http\Controllers;

use App\Data\PostData;
use App\Models\Post;
use App\Repositories\Post\PostRepository;

class PostController extends Controller
{
    public function __construct(
        private PostRepository $posts
    ) {}

    public function index()
    {
        return PostData::collect($this->posts->all());
    }

    public function store(PostData $postData)
    {
        return $this->posts->create($postData);
    }

    public function show(Post $post)
    {
        return $this->posts->findById($post->id);
    }

    public function update(Post $post, PostData $postData)
    {
        return $this->posts->update($post, $postData);
    }

    public function destroy(Post $post)
    {
        return $this->posts->delete($post->id);
    }
}
