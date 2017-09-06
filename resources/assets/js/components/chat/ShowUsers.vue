<template>
  <div>
    <div class="float-right">

        <small v-for="user in onlineusers" :key="user.id">{{ user.name }}, </small>

    </div>
  </div>
</template>



<script>
  export default {
    props: ['onlineusers'],
  }
</script>
