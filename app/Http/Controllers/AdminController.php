<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashierRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('pages.admin-list',['admins' => User::paginate(5)->where('role',User::$ADMIN)]);
    }

    public function create()
    {
        return view('pages.admin-create');
    }

    public function store(CashierRequest $request)
    {   
        User::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'role'=>User::$ADMIN
        ]);

        return redirect(route('admin.admin'))->with([
            'created'=>true,
            'message'=>'Meter Readers Account created successfully!'
        ]);
    }
}
