<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    public function index($id = null) {
        // print_r('here');die;

        $user = Auth::user();
        $friends = User::where('id','<>',$user->id)->orderBy('name','asc')->paginate();

        // $chats = $user->conversations()
        // ->with(['lastMessage',
        // 'participants' => function($q) use ($user){
        //     $q->where('id','<>',$user->id);
        // }
        // ])->get();

        // $messages = [];
        // $activeChat = new Conversation();
        // if ($id) {
        //     $activeChat = $chats->where('id',$id)->first();
        //     $messages = $activeChat->messages()->with('user')->paginate();
        //     // print_r($messages);die;
        // }

        return view('messanger',compact('friends'));
    }




}
