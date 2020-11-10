<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get("search");
        $role_filter = $request->get("role");
        $users = User::when($search, function ($query) use ($search){
            $query->where(function ($query) use ($search){
                $query->where("name", "LIKE", "%$search%")
                    ->orWhere("email", "LIKE", "%$search%");
            });
        })->when($role_filter, function ($query) use ($role_filter){
            $query->where("role_id", $role_filter);
        })->orderBy("name", "asc")->with("role")->paginate(10);

        if ($request->isJson())
            return response()->json($users);

        $roles = Role::orderBy("name", "asc")->get();

        return view("pages.user.index", compact("users", "search", "role_filter", "roles"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $roles = Role::orderBy("name", "asc")->get();

        return view("pages.user.create", compact("user", "roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->only("name", "email", "password", "role");
        $data["password"] = bcrypt($data["password"]);
        $data["role_id"] = $data["role"];
        unset($data["role"]);

        User::create($data);

        return redirect()->route("users.index")->with("success", "User created!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy("name", "asc")->get();

        return view("pages.user.edit", compact("user", "roles"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->only("name", "email", "password", "role");

        // role
        $data["role_id"] = $data["role"];
        unset($data["role"]);

        // password
        if (!empty($data["password"]))
            $data["password"] = bcrypt($data["password"]);
        else
            unset($data["password"]);

        User::where("id", $id)->update($data);

        return redirect()->route("users.index")->with("success", "User updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        $user->delete();

        return redirect()->route("users.index")->with("success", "User deleted!");
    }

    public function blockUser($id){
        $user = User::findOrFail($id);
        $user->is_block = !$user->is_block;
        $user->save();

        return redirect()->route("users.index")->with("success", "User blocked!");
    }
}
