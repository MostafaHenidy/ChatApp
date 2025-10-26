<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Group;
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
    public function group($id)
    {
        $group = Group::findOrFail($id);
        $authUserId = Auth::id();
        $messages = Message::where(function ($query) use ($authUserId, $id) {
            $query->where('sender_id', $authUserId)->where('receiver_id', $id);
        })->orWhere('sender_id', $id)->where('receiver_id', $authUserId)
            ->orderBy('created_at', 'asc')->get();
        return view('front.group', get_defined_vars());
    }
    public function groupManagement($id)
    {
        $group = Group::findOrFail($id);
        $authUserId = Auth::id();
         $messages = Message::where(function ($query) use ($authUserId, $id) {
            $query->where('sender_id', $authUserId)->where('receiver_id', $id);
        })->orWhere('sender_id', $id)->where('receiver_id', $authUserId)
            ->orderBy('created_at', 'asc')->get();
        return view('front.groupManagment', get_defined_vars());
    }
}
