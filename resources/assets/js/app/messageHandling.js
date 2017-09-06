/*

  Contains all methods for the front-end functionality

*/
export default {

  getAllMessages () {
    // get all existing messages
    axios.get('/messages').then((response) => {
      this.messages = response.data;
    });
  },

  addMessage (payload) {
    axios.post('/messages', { message: payload})
      .then((response) => {
        // console.log(response);
        // this.getAllMessages();
      })
  },

  editMessage (payload) {
    console.log('editMessage method: '+payload.message);    
    axios.patch('/messages/'+payload.id, payload)
      .then((response) => {
        if (response.data == 'updated')
          this.getAllMessages();
        else 
          console.log(response);
      })
  },

  deleteMessage (payload) {
    axios.delete('/messages/' + payload)
      .then((response) => {
        if (response.data == 'destroyed') {
          this.messages = this.messages.filter( (elem) => { return elem.id != payload } );
        }
      })
  },

  getCurrentUser () {
    // get the current user object
    axios.get('/user').then((response) => {
      this.user = response.data;
    });
  },

}