<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $messages = Message::with('user')->latest()->take(100)->get()->reverse()->values();
        return view('chat.index', compact('messages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:1000']]);
        $message = $request->user()->messages()->create($data);
        broadcast(new MessageSent($message))->toOthers();
        return back();
    }
}
