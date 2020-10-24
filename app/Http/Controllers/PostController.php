<?php

namespace App\Http\Controllers;

use App\Business\PostBusiness;
use App\Http\Requests\PostRequest;
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
    public function index(Request $request)
    {
        $search = $request->get("search");

        $posts = Post::with("category")->when($search, function ($query) use ($search){
            $query->where("title", "LIKE", "%$search%");
        })->paginate(10);

        $posts->appends(["search" => $search]);

        if ($request->isJson())
            return response()->json($posts);

        return view("pages.post.index", compact("posts", "search"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PostBusiness::getAllCategories();
        $post = new Post();
        $action = route("posts.store");

        return view("pages.post.create", compact("categories", "post", "action"));
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

        $data = $request->only(
            "title", "slug", "category_id", "content", "new_category"
        );

        $data = PostBusiness::insertNewCategory($data);
        Post::create($data);

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
        $post = Post::findOrFail($id);
        $categories = PostBusiness::getAllCategories();
        $action = route("posts.update", $post->id);

        return view("pages.post.edit", compact("post", "categories", "action"));
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
        $post = Post::findOrFail($id);

        $request["slug"] = Str::slug($request->title);

        $data = $request->only(
            "title", "slug", "category_id", "content", "new_category"
        );

        $data = PostBusiness::insertNewCategory($data);
        $post->update($data);

        return redirect()->route("posts.index")->with("success", "Post updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route("posts.index")->with("success", "Post deleted!");
    }
}
