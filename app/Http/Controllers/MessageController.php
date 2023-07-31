<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;


class MessageController extends Controller
{
    //
    public function create(): View
    {
        //$users = User::all();

        $users = User::where('id', '!=', auth()->id())->get();

        return view('send_message', compact('users'));
    }

    public function store(Request $request)
    {
        return $request->all();
    }
}
