<?php

namespace App\Http\Controllers;

use App\Http\Requests\users\UpdateUserRequest;
use App\Models\Customer;
use App\Models\User;
use App\Rules\SamePasswordFromAuthUser;
use App\Rules\ValidRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{


    private $passwordValidationRule=['required','confirmed','min:8'];
    
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

    public function update(User $user,UpdateUserRequest $request)
    {

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
            'deleted'=>true,
            'message'=>"{$user->name}'s account was deleted successfully!"
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'username'=>'required|unique:users,username',
            'password'=>$this->passwordValidationRule,
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

    public function updatePassword()
    {
        return view('pages.users.change-password');
    }

    public function storeNewPassword(Request $request)
    {
        $request->validate([
            'current_password'=>['required',new SamePasswordFromAuthUser],
            'password'=>$this->passwordValidationRule,
        ]);

        $authenticatedUser=Auth::user();
        $authenticatedUser->password=Hash::make($request->password);
        $authenticatedUser->save();

        Auth::logout();
        return redirect(route('login'))->with([
            'updated-password'=>true,
            'message'=>'Password updated successfully! You may log-in again.'
        ]);
    }
}
