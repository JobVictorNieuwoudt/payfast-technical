<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index($chatId)
    {
        $messages = Message::where('chat_id', $chatId)
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->select('messages.*', 'users.name')
            ->where('chat_id', $chatId)
            ->get();

        return Inertia::render('Messages', [
            'messages' => $messages,
        ]);
    }
    public function store(Request $request, $chatId)
    {
        $userId = auth()->user()->id;

        $request->validate([
            'message' => 'required|string'
        ]);

        // create the message and return it
        $message = Message::create([
            'message' => $request->input('message'),
            'user_id' => $userId,
            'chat_id' => $chatId,
        ]);

        // join the users table to the messages table and select the name column
        $message = Message::where('messages.id', $message->id)
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->select('messages.*', 'users.name')
            ->first();

        return response()->json($message);
    }

    public function update(Chat $chat, Message $message, Request $request)
    {
        // Validate and update the message content
        $request->validate([
            'message' => 'required|string|max:255', // Adjust validation rules as needed
        ]);

        $message->update([
            'message' => $request->input('message'),
        ]);

        // Return a response indicating success
        return response()->json(['message' => 'Message updated successfully']);
    }

    public function destroy(Chat $chat, Message $message)
    {
        $message->delete();

        return response()->json(['message' => 'Message deleted successfully']);
    }

}
