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
        $customers=User::paginate(15);
        return view('pages.users.index',[
            'customers'=>$customers
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
            'role'=>'required'
        ]);

        $user->role=$request->role;
        $user->save();

        return redirect(route('admin.users.edit',$user));
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
