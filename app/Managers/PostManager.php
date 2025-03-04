<?php

namespace App\Managers;

use App\Repositories\Post\PostRepository;

class PostManager
{
    public function __construct(protected PostRepository $posts)
    {
        $this->posts = $posts;
    }
}
