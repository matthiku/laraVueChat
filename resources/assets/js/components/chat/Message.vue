<template>
  <li class="list-group-item" :class="ownMessage ? 'bg-light' : '' ">

    <p v-show="!editing" @click="editing = ! editing" class="mb-1">{{ message.message }}</p>
    <p v-show="editing" contenteditable="" class="mb-1 border border-primary" 
       :id="'message-text-id-'+message.id" v-html="message.message"></p>

    <div class="d-flex justify-content-between">
      <div class="small text-white rounded p-1" :class="ownMessage ? 'bg-primary' : 'bg-secondary' ">
        {{ message.user.name }} 
      </div>

      <div v-if="ownMessage" class="small">
        <a href="#" @click="editing=!editing" class="btn btn-sm btn-primary">{{ editing ? 'cancel' : 'edit'}}</a>
        <a href="#" @click="updateMessage" class="btn btn-sm btn-success" v-show="editing">send</a>
        <a href="#" @click="deleteMessage" class="btn btn-sm btn-danger" v-show="!editing">delete</a>
      </div>

      <div class="small text-info">
        {{ formattedDate }}
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
      }
    },

    computed: {
      formattedDate () {
        // format date depending on age
        var d = moment(this.message.created_at);
        if (d.isSame(moment(), 'day'))
            return d.format("LTS");
        if (d.isSame(moment(), 'week'))
            return d.format("ddd, HH:mm");
        return d.format("lll");
      },
    },

    methods: {
      deleteMessage () {
        this.bus.$emit('delete-message', this.message.id);
      },
      updateMessage () {
        this.message.message = $('#message-text-id-'+this.message.id).text();
        this.bus.$emit('update-message', this.message);
        this.editing = false;
      },
    },

    mounted () {
      if (this.message.user_id == this.user.id)
        this.ownMessage = true;
    },

    watch: {
      user (what) {
        if (this.message.user_id == this.user.id)
          this.ownMessage = true;
      }
    },

  }
</script>
