<?php

namespace App\Http\Controllers\Backend;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipperMessageController extends Controller
{
  public function index()
  {
    $userId = Auth::user()->id;

    $chatUsers = Chat::with('receiverProfile')->select(['receiver_id'])->where('sender_id', $userId)
      ->where('receiver_id', '!=', $userId)
      ->groupBy('receiver_id')
      ->get();

    return view('shipper.message.index', compact('chatUsers'));
  }

  // get all message between sender and receiver
  public function getMessages(Request $request)
  {
    $senderId = Auth::user()->id;
    $receiverId = $request->receiver_id;

    $messages = Chat::whereIn('receiver_id', [$senderId, $receiverId])
      ->whereIn('sender_id', [$senderId, $receiverId])->orderBy('created_at', 'ASC')->get();

    Chat::where(['sender_id' => $receiverId, 'receiver_id' => $senderId])->update(['seen' => 1]);

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

    Chat::where(['sender_id' => $request->receiver_id, 'receiver_id' => Auth::user()->id])->update(['seen' => 1]);

    return response(['status' => 'success', 'message' => 'Message has been sent.']);
  }
}
