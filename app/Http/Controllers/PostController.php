<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Repository\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $post;
    public function __construct(

        PostRepository $postRepository
    ) {

        $this->post = $postRepository;
    }


    public function index(Request $request)
    {
        $posts = $this->post->pagination($request, 15);
        return PostResource::collection($posts);
    }
}
