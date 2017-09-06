
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

/**
 * 
 * Load the components 
 *
 */
require('./components/components');

/**
 * 
 * Get the methods 
 *
 */
import methods from './app/messageHandling';

// create a direct communications bus
var bus = new Vue();

/**
 *
 * Create a fresh Vue application instance and attach it to the page. 
 *
 */
const app = new Vue({
  
  el: '#app',

  data: {
    messages: [],
    user: {},
    onlineusers: [],
    bus: bus,
  },

  methods: methods,

  created () {
    this.getCurrentUser();
    this.getAllMessages();

    this.bus.$on('delete-message', (id) => {
      this.deleteMessage(id); 
    });
    this.bus.$on('update-message', (id) => {
      this.editMessage(id); 
    });

    /* 
      Open channel between all logged in users

      start listening and maintain a list of active users
    */
    Echo.join('chatroom')

      .here((users) => {
          this.onlineusers = users;
      })
      .joining((user) => {
          if (_.findIndex(this.onlineusers, (o) => { return o.id == user.id; }) < 0)
            this.onlineusers.push(user);
      })
      .leaving((user) => {
          this.onlineusers = this.onlineusers.filter( (elem) => { return elem.id != user.id } );
      })

      .listen('MessagePosted', (e) => {
        if (e.message && e.message.message) {
          var msg = e.message;
          msg.user = e.user;
          this.messages.unshift(msg);
        }
        else {
          console.log('Event MessagePosted returned incorrect value!');
          console.log(e);
        }
      })
      .listen('MessageUpdated', (e) => {
        console.log('MessageUpdated:');
        console.log(e);
        if (e.message && e.message.message) {
          var msg = e.message;
          msg.user = e.user;
          this.messages.unshift(msg);
        }
        else {
          console.log('Event MessagePosted returned incorrect value!');
          console.log(e);
        }
      })
      .listen('MessageDeleted', (id) => {
        if (id && id.message_id) {
          // remove the deleted message from the local array
          this.messages = this.messages.filter( (elem) => { return elem.id != id.message_id } );
        }
        else {
          console.log('Event MessageDeleted returned incorrect value!');
          console.log(id);
        }
      })
    ;
  },

});
