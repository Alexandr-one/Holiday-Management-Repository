<?php

namespace App\Repositories\Admin;

use App\Position;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class PostRepository
{
    /**
     * Получение должностей
     *
     * @return mixed
     */
    public function showPosts()
    {
        return  Position::paginate(10);
    }

    /**
     * Добавление должностей
     *
     * @param $requestData
     * @return Position
     */
    public function createPost($requestData)
    {
        Log::info('[PostRepository] Create Post: '.  Arr::get($requestData, 'name'));

        return Position::create([
            'name' => Arr::get($requestData, 'name'),
            'name_parent_case' => Arr::get($requestData, 'name_parent_case')
        ]);
    }

    /**
     * Изменение должностей
     *
     * @param $requestData
     * @return bool
     */
    public function updatePost($requestData)
    {
        $post = Position::findOrFail(Arr::get($requestData,'id'));
        Log::info('[PostRepository] Update Post: '.  Arr::get($requestData, 'name'));
        $post->name = Arr::get($requestData,'name');
        $post->name_parent_case = Arr::get($requestData,'name_parent_case');
        $post->save();

        return $post;
    }

    /**
     * Удаление должностей
     *
     * @param $requestData
     * @return bool
     */
    public function deletePost($requestData)
    {
        $post = Position::findorfail(Arr::get($requestData,'post_id'));
        Log::info('[PostRepository] Delete Post: '.  Arr::get($requestData, 'post_id'));
        if ($post->users->count() != 0) {
            $post = false;
        } else {
            $post->delete();
            $post = true;
        }

        return $post;
    }
}
