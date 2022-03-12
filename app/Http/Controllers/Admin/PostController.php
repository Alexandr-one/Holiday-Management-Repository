<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePositionRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\Admin\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /** @var PostRepository */
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(
        PostRepository $postRepository
    )
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Получение должностей
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = $this->postRepository->showPosts();

        return view('admin/posts/index', compact('posts'));
    }

    /**
     * Добавление должностей
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPosition(PostRequest $request)
    {
        $post = $this->postRepository->createPost($request->all());
        if ($post) {
            session()->flash('createSuccess', 'Должность '. $post->name . ' добавлена');
        } else {
            session()->flash('error','Должность не добавлена');
        }

        return redirect()->back();
    }

    /**
     * Изменение должностей
     *
     * @param UpdatePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePosition(UpdatePostRequest $request)
    {
        $post = $this->postRepository->updatePost($request->all());
        if ($post) {
            session()->flash('updateSuccess','Должность '. $post->name .' изменена');
        }

        return redirect()->back();
    }

    /**
     * Удаление должностей
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePosition(DeletePositionRequest $request)
    {
        $post = $this->postRepository->deletePost($request->all());
        if (!$post) {
            session()->flash('deleteError','Нельзя удалять должности, на которых есть сотрудники');
        } else {
            session()->flash('updateSuccess','Должность успешно удалена');
        }

        return redirect()->back();
    }
}
