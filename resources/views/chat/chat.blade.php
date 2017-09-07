@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <div class="card p-1">

          <div class="card-header sticky-top bg-light">
            Chatroom
            <span class="float-right">
              <span class="badge badge-secondary" title="how many users are online">@{{ onlineusers.length }}</span>
              logged on users
            </span>
            <chat-show-users :onlineusers="onlineusers"></chat-show-users>
          </div>


          <div class="card-body p-0">
            <chat-log 
              :messages="messages" 
              :user="user"
              :bus="bus"
            ></chat-log>
          </div>

          <div class="card-footer bg-secondary rounded my-1" id="new-chat-message">
            <chat-new-message 
              v-on:send-message="addMessage"
            ></chat-new-message>
          </div>
          
        </div>
      </div>
    </div> {{-- row --}}
  </div> {{-- container --}}

@endsection
