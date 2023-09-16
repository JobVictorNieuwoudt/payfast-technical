<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin) {
            $chats = Chat::leftJoin('users', 'chats.user_id', '=', 'users.id')
                ->leftJoin('messages', function($join) {
                    $join->on('chats.id', '=', 'messages.chat_id')
                        ->whereRaw('messages.id = (SELECT MAX(id) FROM messages WHERE chat_id = chats.id)');
                })
                ->select('chats.id', 'users.name', 'chats.description', DB::raw('COALESCE(messages.created_at, NULL) as date'))
                ->get();
        } else {
            $chats = Chat::where('user_id', Auth::user()->id)->get();
        }

        return response()->json($chats);
    }

    public function showCreate()
    {
        return Inertia::render('CreateChat');
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $request->validate([
            'description' => 'required|string'
        ]);

        Chat::create([
            'description' => $request->input('description'),
            'user_id' => $userId,
        ]);
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();

        return redirect()->route('chats.index');
    }


}
