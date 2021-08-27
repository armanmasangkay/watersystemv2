<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserPasswordController extends Controller
{
    public function update(User $user,Request $request)
    {
    
        $user->password=Hash::make(User::defaultPassword());
        $user->save();
        return redirect()->route('admin.users.index')->with([
            'resetted-password'=>true,
            'message'=>"{$user->name}'s password was resetted successfully!"
        ]);
    }
}
