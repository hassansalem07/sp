<?php

namespace App\Http\Controllers\Back;

use App\{
    Models\Post,
    Repositories\Back\PostRepository,
    Http\Requests\ImageStoreRequest,
    Http\Requests\ImageUpdateRequest,
    Http\Controllers\Controller
};
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     * @param  \App\Repositories\Back\PostRepository $repository
     *
     */
    public function __construct(PostRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.post.index',[
            'datas' => Post::with('category')->orderBy('id','desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'photo*' => 'required|image',
        ]);

        $this->repository->store($request);
        return redirect()->route('back.post.index')->withSuccess(__('New Review Added Successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('back.post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'photo*' => 'image',
        ]);

        $this->repository->update($post, $request);
        return redirect()->route('back.post.index')->withSuccess(__('Review Updated Successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->repository->delete($post);
        return redirect()->route('back.post.index')->withSuccess(__('Post Deleted Successfully.'));
    }


    public function delete($key,$id)
    {
        $this->repository->photoDelete($key,$id);
        return back()->withSuccess(__('Photo Deleted Successfully.'));

    }
}
