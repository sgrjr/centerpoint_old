<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Room;

class ChatsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function renderChat(Request $request, $room = null)
    {
        $rooms = Room::all()->pluck('name')->toArray();
        if ($room === 'general') return redirect()->route('chat');
        if (!$room) $room = "general";
        if (!in_array($room, $rooms)) abort(404);
        return Inertia::render('Chat', [
            'chatData' => [
                'messages' => Room::where('name', $room)->first()->messages()->with('user')->get(),
                'rooms' => $rooms,
                'room' => $room
            ]
        ]);
    }

    public function index()
    {
        return view('chat');
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'room' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:140'],
        ]);
        $user = $request->user();
        $room = Room::where('name', $request->room)->firstOrFail();
        $message = $user->messages()->create([
            'message' => $request->message,
            'room_id' => $room->id
        ]);
        broadcast(new MessageSent($user, $room, $message))->toOthers();
        return Response::json(['ok' => true]);
    }
}