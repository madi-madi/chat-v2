<template>
  

                <!-- Trigger the modal with a button -->
            
            <div>
                <!-- Modal -->
                <div  class="modal fade show" style="display:block;background-color: #5a55554f;overflow-x: hidden;
                overflow-y: auto;  padding-right: 10px;"  v-if="openModal">
                  <div class="modal-dialog" style="margin: 5.75rem auto;">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                      </div>
                      <div class="modal-body">
                        <p>Create New Room </p>
                          <form method="post" enctype="multipart/form-data"  v-on:submit.prevent="create_room()" id="room">

                            <div class="form-group">
                            <label for="room">Room Name</label>
                            <input type="text" name="room_name" class="form-control" v-model="room_name">
                          </div>
                            <div class="form-group">
                            <label for="image">Room Image</label>
                            <input type="file" name="image" class="form-control" 
                            ref="file">
                          </div>
                          <div class="modal-footer">
                             <button type="submit" class="btn btn-default " >Create</button> <button type="button" class="btn btn-default" @click="close">Close</button>
                           </div>

                          </form>
                       


                      </div>
                    </div>

                  </div>
                </div>
              </div>

</template>

<script>
    export default {
      props:['openModal'],
      data(){
        return{
            'room_name':'',
            
        }
      },

    methods:{

        close(){

         this.$emit('closemodal')
        },

    create_room()
    {
      console.log('yes');

      let formData = new FormData(document.getElementById('room'));
      
    

          axios.post('/create/room',formData, {
         headers: {
                'Content-Type': 'multipart/form-data'
                  }} ).then(response => {
                        this.close();
                        this.$refs.file.value = null;
                        console.log(response.data.data);
                        this.$parent.rooms.push(response.data.data);

                  }).catch(error => {
                    console.log(error);
                    });
    },


    },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
