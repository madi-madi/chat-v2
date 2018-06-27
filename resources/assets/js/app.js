
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

// import { Picker , Emoji } from 'emoji-mart-vue'
window.moment = require('moment');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// let Emoji = require('./components/Emoji.vue');

Vue.component('message-component', require('./components/MessageComponent.vue'));
Vue.component('create-room', require('./components/CreateRoomComponent.vue'));

            // var socket = io('http://localhost:3000');
            // var socket = io();

              // var socket = io.connect('https://morning-ravine-43773.herokuapp.com/');
            var socket = io('http://localhost:3000');
              
            // var socket = io.connect(window.location.hostname);//127.0.0.1:3000




const app = new Vue({
    el: '#app',
    // components:{Picker,Emoji },

    data: {
             users:[],
             rooms:{},
             messages:[],
             search_result:[],
             view_data:[],
             'loading':true,
             'showView':false,
             'typing':'',
             'id':'',
             'file':'',
             'token':'',
             'notify':'',
             room_info:'',
             'room_id':'',
             'room_name':'',
             'roomName':'',
             'room_socket':'',
             'msgFrom':'',
             'input_message':false,
             'join_user':false,
             
              status:['typing'],
             
          },
  created(){
      axios.get('/rooms')
           .then(response => {
            console.log(response.data.notifications);
            app.notify = response.data.notifications;
             app.rooms = response.data.data;
             app.view_data = this.rooms;
           })
            .catch(error => {
              console.log(error);
            });
    },
    watch:{
      msgFrom(){
        if (this.msgFrom.length != '') {
        console.log(this.msgFrom);
        var type = [type_room => 'typing']
          socket.emit('Typing',this.status,this.room_socket);

          
        }else{
          this.status = [];
          socket.emit('Typing',this.status,this.room_socket);
          this.status = ['typing'];
        }
      }
    },
    computed:{ },
   methods:{
    mention(){
      this.room_info.id;
        //      axios.get('/mention/',{
        //       room_id: this.room_info.id,

        //      }).then(response => {
        //      // app.search_result = response.data.data;
        //      // app.users = ;
        // }).catch(error => {

        // });
        app.users = this.room_info.users;
      console.log(this.room_info.id);
    },
    openShow(){
      app.showView = true;
    },
    close(){

          this.showView =false;
        },

    // create_room()
    // {
    //   console.log('yes');
    //   let formData = new FormData(document.getElementById('create_room'));

    //      axios.post('/create/room',formData, {
    //         headers: {
    //           'Content-Type': 'multipart/form-data'
    //        }} ).then(response => {
              
    //          this.rooms.push(response.data.data);
    //          app.room_name = '';
    //       }).catch(error => {
    //           console.log(error);
    //       });
    // },

    search_room(e){

      if (this.roomName.length != '') {
       axios.get('/search/'+this.roomName).then(response => {
             app.search_result = response.data.data;
             app.view_data = this.search_result;
        }).catch(error => {

        });

      }else{ 
        app.search_result = [];
        app.view_data = this.rooms; 

      }

    },

    getImage(e){
      var files = e.target.files[0];
      this.file = files;
      this.token = document.getElementsByTagName("input")[0].value;
    },


    send(e)
    {

      let formData = new FormData(document.getElementById('mesg'));
      
      if (this.msgFrom.length != '' || formData != 0) {

          axios.post('/send/message',formData, {
         headers: {
                'Content-Type': 'multipart/form-data'
                  }} ).then(response => {
                        this.$refs.file.value = null;
         
                socket.emit('newMessage',response.data.data , this.room_socket );
                 this.messages[0].push(response.data.data);

                  }).catch(error => {
                    console.log(error);
                    });
          app.msgFrom = '';
          app.file = '';
      }
    },
   openRoom(key , id){

        axios.get(`/room/${id}`)
              .then(response => {
                app.join_user = response.data.data;
                app.input_message = !response.data.data;
                app.messages = [];
                app.room_id = id;
                app.room_info = response.data.data_room;//this.rooms[key];
                app.messages.push(response.data.data_msg);
                app.loading = false;
                app.room_socket = this.room_info.name;
                socket.emit('joinRoom',this.room_socket);
              })
              .catch(error => {
                console.log(error);
              });

      },
      join_room(){
        app.messages = [];
                axios.post('/join/room',{
                  room_id:this.room_id
          }).then(response => {
            console.log(response.data.data_room);
         socket.emit('newMessage',response.data.join_message , this.room_socket );
         this.messages.push(response.data.data);
         this.room_info = '',
         this.room_info = response.data.data_room,
         socket.emit('newUserJoin',response.data.data_room , this.room_socket );

          app.join_user = ! this.join_user;
          app.input_message = ! this.input_message;

          }).catch(error => {
                  console.log(error);
              });
      }

   },

    mounted(){
      socket.on('clientMessage', function(data){
        this.messages[0].push(data);

      }.bind(this));

            socket.on('roomTyping', function(data){
       this.typing = data;
       console.log(this.typing);

      }.bind(this));

      socket.on('joinNewUser', function(data){
       this.room_info = '';
       this.room_info = data;


      }.bind(this));
     }
});
