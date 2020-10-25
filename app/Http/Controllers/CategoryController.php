<?php

namespace App\Http\Controllers;

use App\Business\CategoryBusiness;
use App\Helpers\CategoryHelper;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get("search");

        $categories = Category::when($search, function ($query) use ($search){
            $query->where("title", "LIKE", "%$search%");
        })->paginate(10);

        $categories->appends(["search" => $search]);

        if ($request->isJson())
            return response()->json($categories);

        return view("pages.category.index", compact("categories", "search"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();

        return view("pages.category.create", compact("category"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        CategoryBusiness::store($request->title);

        return redirect()->route("categories.index")->with("success", "Category created!");
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
        if (CategoryHelper::isUncategorize($id))
            return abort(403);

        $category = Category::findOrFail($id);

        return view("pages.category.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if (CategoryHelper::isUncategorize($id))
            return abort(403);

        $category = Category::findOrFail($id);

        $request["slug"] = Str::slug($request->title);

        $category->update($request->only("title", "slug"));

        return redirect()->route("categories.index")->with("success", "Category updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1)
            return abort(403);

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route("categories.index")->with("success", "Category deleted!");
    }
}
