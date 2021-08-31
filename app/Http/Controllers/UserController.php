<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users=User::paginate(15);
        return view('pages.users.index',[
            'users'=>$users
        ]);
    }
    public function create()
    {

        return view('pages.users.create',[
            'roles'=>User::validRoles()
        ]);
    }

    public function edit(User $user, Request $request)
    {
        return view('pages.users.edit',[
            'user'=>$user,
            'roles'=>User::validRoles()
        ]);
    }

    public function update(User $user,Request $request)
    {

        $request->validate([
            'role'=>'required',
            'name'=>'required'
        ]);

        $user->role=$request->role;
        $user->name=$request->name;
        $user->save();

        return redirect(route('admin.users.edit',$user))->with([
                'updated'=>true,
                'message'=>"Account was updated successfully!"
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with([
            'resetted-password'=>true,
            'message'=>"{$user->name}'s account was deleted successfully!"
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'username'=>'required|unique:users,username',
            'password'=>['required','confirmed','min:8'],
            'role'=>'required'
        ]);

        User::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'role'=>$request->role
        ]);

        return redirect(route('admin.users.index'))->with([
            'created'=>true,
            'message'=>'User Account created successfully!'
        ]);
    }
}
