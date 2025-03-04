<?php

namespace App\Managers;

use App\Repositories\Post\PostRepository;

class PostManager
{
    protected PostRepository $posts;

    public function __construct()
    {
        $this->posts = new PostRepository();
    }
}
