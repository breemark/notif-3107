<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\MessageSent;
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

        $this->validate($request, [
            'body' => 'required',
            'recipient_id' => 'required|exists:users,id'
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $request->recipient_id,
            'body' => $request->body
        ]);

        $recipient = User::find($request->recipient_id);

        $recipient->notify(new MessageSent($message));

        return back()->with('flash', 'Your message has been sent');
    }
}
