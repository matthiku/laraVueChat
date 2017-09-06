@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10">
      <div class="card">

        <div class="card-header">
          Chatroom
          <span class="float-right">
            <span class="badge badge-secondary" title="how many users are online">@{{ onlineusers.length }}</span>
            logged on users
          </span>
          <chat-show-users :onlineusers="onlineusers"></chat-show-users>
        </div>


        <div class="card-body">

          <chat-new-message 
            v-on:send-message="addMessage"
          ></chat-new-message>

          <chat-log 
            :messages="messages" 
            :user="user"
            :bus="bus"
          ></chat-log>

        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection
