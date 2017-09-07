/*

  Contains all methods for the front-end functionality

*/
export default {

  getAllMessages () {
    // get all existing messages
    axios.get('/messages')
      .then((response) => {
        this.messages = response.data;
      });
  },

  addMessage (payload) {
    // send the new message to the backend
    axios.post('/messages', { message: payload})
      .then((response) => {
        // once the backend processed the new message, it will be broadcasted
        // console.log(response);
      })
  },

  editMessage (payload) {
    axios.patch('/messages/'+payload.id, payload)
      .then((response) => {
        if (response.data == 'updated')
          this.getAllMessages();
        else 
          console.log(response);
      })
  },

  deleteMessage (payload) {
    if (parseInt(payload) == isNaN)
      return;
    axios.delete('/messages/' + payload)
      .then((response) => {
        if (response.data == 'destroyed') {
          this.messages = this.messages.filter( (elem) => { return elem.id != payload } );
        }
        else 
          console.log(response);
      })
  },

  getCurrentUser () {
    // get the current user object
    axios.get('/user').then((response) => {
      this.user = response.data;
    });
  },

}