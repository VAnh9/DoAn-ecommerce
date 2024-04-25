<?php

namespace App\Http\Controllers\Backend;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
  // get profile users chat with
  public function index()
  {
    $userId = Auth::user()->id;

    $chatUsers = Chat::with('senderProfile')->select(['sender_id'])
      ->where('receiver_id', $userId)
      ->where('sender_id', '!=', $userId)
      ->groupBy('sender_id')
      ->get();


    return view('admin.message.index', compact('chatUsers'));
  }

  // get all message between sender and receiver
  public function getMessages(Request $request)
  {
    $receiverId = Auth::user()->id;
    $senderId = $request->sender_id;

    $messages = Chat::whereIn('receiver_id', [$receiverId, $senderId])
      ->whereIn('sender_id', [$receiverId, $senderId])
      ->orderBy('created_at', 'ASC')
      ->get();

    return response($messages);
  }

  public function sendMessage(Request $request)
  {
    $request->validate([
      'message' => ['required'],
      'receiver_id' => ['required']
    ]);

    $message = new Chat();

    $message->sender_id = Auth::user()->id;
    $message->receiver_id = $request->receiver_id;
    $message->message = $request->message;

    $message->save();

    broadcast(new MessageEvent($message->message, $message->receiver_id, $message->created_at));

    return response(['status' => 'success', 'message' => 'Message has been sent from admin!']);
  }
}
