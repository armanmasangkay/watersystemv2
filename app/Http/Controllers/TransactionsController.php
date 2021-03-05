<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        return view('pages.new-transaction');
    }
}
