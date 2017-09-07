<?php

namespace App\Http\Controllers;

use Auth;
use App\Message;
use App\Events\MessagePosted;
use App\Events\MessageDeleted;
use App\Events\MessageUpdated;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Message::with('user')->orderBy('created_at', 'ASC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get current user object
        $user = Auth::user();

        // create new message object
        $message = new Message(['message' => $request->get('message')]);

        // save it in the user's context
        $user->messages()->save($message);

        // announce that a new message was psoted
        event(new MessagePosted($message, $user));

        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // find the message, check if the current user owns it, then delete it
        $msg = Message::find($id);

        if ($msg && $msg->user_id == Auth::id()) {
            $msg->update(['message' => $request->message]);
            event(new MessageUpdated($msg, Auth::user())); 
            return 'updated';
        }
        return 'failed!';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find the message, check if the current user owns it, then delete it
        $msg = Message::find($id);
        if ($msg && $msg->user_id == Auth::id()) {
            event(new MessageDeleted($id)); 
            $msg->delete();
            return 'destroyed';
        }
        return 'failed!';
    }
}
