<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with("category")->paginate(10);

        return view("pages.post.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy("title", "asc")->get();

        return view("pages.post.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $request["slug"] = Str::slug($request->title);

        Post::create($request->only(
            "title", "slug", "category_id", "content"
        ));

        return redirect()->route("posts.index")->with("success", "Post created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::orderBy("title", "asc")->get();

        return view("pages.post.edit", compact("post", "categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $request->validate([
            "title" => "required|max:191|unique:posts,title,".$id."id",
            "category_id" => "required|numeric",
            "content" => "required|max:1000",
        ]);

        $request["slug"] = Str::slug($request->title);

        Post::where("id", $id)->first()->update($request->only(
            "title", "slug", "category_id", "content"
        ));

        return redirect()->route("posts.index")->with("success", "Post created!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);

        return redirect()->route("posts.index")->with("success", "Post deleted!");
    }
}
