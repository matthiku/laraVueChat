/*

  Open and maintain the Websockets channel between Laravel's backend and this frontend

*/
export default function () {
  /* 
    Open channel between all logged in users

    start listening and maintain a list of active users
  */
  Echo.join('chatroom')


    .here((users) => {
      // receivin glist of all currently online users
      this.onlineusers = users;
    })
    .joining((user) => {
      // another user joined the chatroom
      if (_.findIndex(this.onlineusers, (o) => { return o.id == user.id; }) < 0)
        this.onlineusers.push(user);
    })
    .leaving((user) => {
      // a user left the chatroom
      this.onlineusers = this.onlineusers.filter( (elem) => { return elem.id != user.id } );
    })


    .listen('MessagePosted', (e) => {
      // insert the new message at the beginning 
      if (e.message && e.message.message) {
        var msg = e.message;
        msg.user = e.user;
        this.messages.push(msg);
      }
      else {
        console.log('Event MessagePosted returned incorrect value!');
        console.log(e);
      }
    })

    .listen('MessageUpdated', (e) => {
      if (e.message && e.message.message) {
        var msg = e.message;
        msg.user = e.user;
        var idx = this.messages.findIndex((elem) => {
          return elem.id == e.message.id;
        });
        // change the array using the build-in set function in order to trigger the DOM update
        this.$set(this.messages, idx, msg);
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
}