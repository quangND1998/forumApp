<?php

namespace App\Repository;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    protected function model()
    {
        return new Post;
    }

    public function pagination($request, $page)
    {
        return  $this->model()->where(function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->term . '%');
        })->paginate($page)->appends(['term' => $request->term]);
    }
}
