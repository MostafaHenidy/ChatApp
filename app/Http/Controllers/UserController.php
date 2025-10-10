<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $friends = Auth::user()->friends;
        return view('front.index', get_defined_vars());
    }
    public function chat($id)
    {
        $friend = User::findOrFail($id);
        $authUserId = Auth::id();
        $messages = Message::where(function ($query) use ($authUserId, $id) {
            $query->where('sender_id', $authUserId)->where('receiver_id', $id);
        })->orWhere('sender_id', $id)->where('receiver_id', $authUserId)
            ->orderBy('created_at', 'asc')->get();
        return view('front.chat', get_defined_vars());
    }
    // public function sendMessage(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'body' => 'required|string',
    //     ]);

    //     $message = Message::create([
    //         'sender_id'   => Auth::id(),
    //         'receiver_id' => $id,
    //         'body'        => $validated['body'],
    //     ]);

    //     // Broadcast event
    //     // messageSent::dispatch($message);

    //     // If request is AJAX, return JSON
    //     if ($request->ajax()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => $message,
    //         ]);
    //     }
    //     return redirect()->back()->with('success', 'Message sent successfully');
    // }
}
