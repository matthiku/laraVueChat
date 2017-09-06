<template>
  <div class="container mb-2">
    <div class="row">
      <div class="w-100">
        <div class="card">
          <div class="card-header">New Message</div>
          <div class="card-body">

            <div class="d-flex">              
              <input type="text" class="w-100" placeholder="enter your message and press Enter"
                  v-model="messageText"
                  @keyup.enter="sendMessage"
                  @keydown="errorText=''"
              >
              <button type="button" class="btn btn-primary rounded-0 rounded-right"
                  :class="messageText ? '' : 'disabled'"
                  :title="messageText ? '' : 'disabled - enter your message first'"
                  @click="sendMessage"
              >Send</button>
            </div>

            <div v-show="errorText" class="alert alert-danger">
              &#10071;&nbsp;{{ errorText }}
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
  export default {
    data () {
      return {
        messageText: '',
        errorText: '',
      }
    },

    methods: {
      sendMessage() {
        if (this.messageText) {
          // eslint-disable-next-line
          // console.log('send-message');
          this.$emit('send-message', this.messageText);
          this.messageText = '';
          this.errorText = '';
        } 
        else 
          this.errorText = 'Please enter your message first!';
      },
    },
  }
</script>
