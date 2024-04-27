<?php

namespace App\Http\Controllers\Frontend;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserMessageController extends Controller
{
  // get all chat users of a sender
  public function index()
  {
    $userId = Auth::user()->id;

    $chatUsers = Chat::with('receiverProfile')->select(['receiver_id'])->where('sender_id', $userId)
      ->where('receiver_id', '!=', $userId)
      ->groupBy('receiver_id')
      ->get();


    // $latestMessage = Chat::where('receiver_id', $userId)
    // ->orderByDesc('created_at')
    // ->get();

    // $chatUserIds = $latestMessage->pluck('sender_id')->unique()->toArray();

    // $chatUsers = Chat::with('senderProfile')->select(['sender_id'])->whereIn('sender_id', $chatUserIds)->groupBy('sender_id')->orderByDesc(DB::raw('MAX(created_at)'))->get();


    return view('frontend.dashboard.message.index', compact('chatUsers'));
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
}
