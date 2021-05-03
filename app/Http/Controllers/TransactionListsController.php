<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionListsController extends Controller
{
    public function index()
    {
        return view('pages.transactions-lists', ['route' => 'admin.transactions-lists']);
    }
}
