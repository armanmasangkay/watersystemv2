<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashierRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MeterReaderController extends Controller
{
    public function index()
    {
        return view('pages.meter-reader',['meter_readers' => User::paginate(5)->where('role',User::$READER)]);
    }

    public function create()
    {
        return view('pages.meter-reader-create');
    }

    public function store(CashierRequest $request)
    {   
        User::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'role'=>User::$READER
        ]);

        return redirect(route('admin.reader'))->with([
            'created'=>true,
            'message'=>'Meter Readers Account created successfully!'
        ]);
    }
}
