<template>
  <div>
    <div class="d-flex">
      <input type="text" class="rounded pl-2 w-100" placeholder="write something and press Enter"
          v-model="messageText"
          @keyup.enter="sendMessage"
          @keydown="errorText=''"
      >
      <button type="button" class="btn btn-primary rounded-0 rounded-right"
          :class="messageText ? '' : 'disabled'"
          :title="messageText ? '' : 'disabled - enter your message first'"
          @click="sendMessage"
      ><h2>&#128389;</h2></button>
    </div>

    <div v-show="errorText" class="alert alert-danger">
      &#10071;&nbsp;{{ errorText }}
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


<style scoped="">
  button h2 {
    line-height: .4;
  }
</style>
