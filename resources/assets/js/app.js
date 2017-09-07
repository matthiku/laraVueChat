
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
import channel from './app/channelHandling';

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
    messages: {},
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
  },

  mounted: channel,

  updated () {
    // scroll down to the new message
    window.location.href = '#new-chat-message'    
  },


});
