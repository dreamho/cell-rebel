<?php namespace Ranking\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Ranking\Http\Controllers\Controller;
use Ranking\User;

class UserController extends Controller
{
    private $activeMenu = 'users';

    public function __construct()
    {
        $this->middleware('admin');
    }


    public function listAdmins(Request $request)
    {
        $users = User::all()->sortByDesc('id');
        return view('admin.content.users', ['users' => $users, 'activeMenu' => $this->activeMenu]);
    }

    public function changeStatus(Request $request)
    {
        $user = User::where('id', $request->route('id'))->first()->toggleAdmin()->save();
        return response()->json($user);
    }

    public function delete(Request $request)
    {
        User::where('id', $request->route('id'))->delete();
        return response(null, 204);
    }
}