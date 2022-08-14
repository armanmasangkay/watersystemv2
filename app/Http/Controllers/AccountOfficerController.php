<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountOfficerController extends Controller
{
    public function index()
    {
        $accounts = Account::all();

        return view('account-officer.dashboard', ['accounts' => $accounts]);
    }
    public function resetPassword(Account $account)
    {
        $account->password = Hash::make('1234');
        $account->save();
        return redirect('/account-officer/dashboard/')
                ->with(
                    'message',
                    $account->account_number . ' password is updated successfully!'
                );
    }
}
