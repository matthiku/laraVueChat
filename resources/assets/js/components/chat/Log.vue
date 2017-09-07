<template>
  <div class="container">
    <div class="row">
      <div class="w-100">
        <div class="card">

          <div class="card-body p-0">
            <ul class="list-group">
              <chat-message 
                  v-for="message in messages" 
                  :key="message.id" 
                  :message="message"
                  :user="user"
                  :bus="bus"
              ></chat-message>
            </ul>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['messages', 'user', 'bus'],
    
    data() {
      return {
      }
    },
  }
</script>
