<template>
  <li class="list-group-item" :class="ownMessage ? 'bg-light text-right' : '' ">

    <p v-show="!editing" @click="clickOnMessage" class="mb-1">{{ message.message }}</p>

    <p  contenteditable="" 
        v-if="ownMessage"
        v-show="editing" 
        v-html="message.message"
        @keyup.enter="updateMessage"
        :id="'message-text-id-'+message.id" 
        class="mb-1 border border-primary px-2 text-left" 
        ></p>

    <div class="d-flex justify-content-between">
      <div v-if="!ownMessage" class="small text-white rounded p-1" :class="ownMessage ? 'bg-primary' : 'bg-secondary' ">
        {{ message.user.name }} 
      </div>

      <div v-if="ownMessage" class="small">
        <button @click="clickOnMessage" class="btn btn-sm btn-primary">{{ editing ? 'cancel' : 'edit'}}</button>
        <button @click="updateMessage" class="btn btn-sm btn-success" v-show="editing">send</button>
        <button @click="deleteMessage" class="btn btn-sm btn-danger" v-show="!editing">delete</button>
      </div>

      <div class="small text-info" :title="message.created_at">
        {{ createdDate }}
        <span v-if="updated" class="small text-warning" :title="message.updated_at">
          (edited: {{ editedDate }})</span>
      </div>
    </div>

  </li>
</template>



<script>
  export default {

    props: ['message', 'user', 'bus'],

    data () {
      return {
        ownMessage: false,
        editing: false,
        updated: false,
      }
    },

    computed: {
      createdDate () {
        // format the displayed date-time depending on age
        var d = moment(this.message.created_at);
        if (d.isSame(moment(), 'day'))
            return d.format("LTS");
        if (d.isSame(moment(), 'week'))
            return d.format("ddd, HH:mm");
        return d.format("lll");
      },
      editedDate () {
        // format the displayed date-time depending on age
        var d = moment(this.message.updated_at);
        if (d.isSame(moment(), 'day'))
            return d.format("LTS");
        if (d.isSame(moment(), 'week'))
            return d.format("ddd, HH:mm");
        return d.format("lll");
      },
    },

    methods: {
      clickOnMessage () {
        // only accept a click if the user owns this message
        if (this.ownMessage) {
          this.editing = ! this.editing;
          if (this.editing) 
            setTimeout(this.setFocus, 200);
        }
      },
      setFocus () {
        var elem = document.getElementById('message-text-id-'+this.message.id);
        elem.focus();
        // now make sure the caret is at the end of the text
        var range,selection;
        if(document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
        {
            range = document.createRange();//Create a range (a range is a like the selection but invisible)
            range.selectNodeContents(elem);//Select the entire contents of the element with the range
            range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
            selection = window.getSelection();//get the selection object (allows you to change selection)
            selection.removeAllRanges();//remove any selections already made
            selection.addRange(range);//make the range you have just created the visible selection
        }
      },

      deleteMessage () {
        // send event to delete a message -> messageHandling.js
        this.bus.$emit('delete-message', this.message.id);
      },
      updateMessage () {
        // send event to update a message -> messageHandling.js

        // first, read updated message text and apply it to the message object
        this.message.message = $('#message-text-id-'+this.message.id).text();
        // now send the event
        this.bus.$emit('update-message', this.message);
        // restore non-editing mode 
        this.editing = false;
      },
    },

    mounted () {
      // check if current message belongs to current user
      if (this.message.user_id == this.user.id)
        this.ownMessage = true;
      // check if message was updated after first publishing
      if (this.message.updated_at != this.message.created_at)
        this.updated = true;
    },

    watch: {
      user (what) {
        if (this.message.user_id == this.user.id)
          this.ownMessage = true;
      }
    },

  }
</script>
