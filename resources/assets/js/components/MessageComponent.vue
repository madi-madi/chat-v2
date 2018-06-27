<template>
 <div>
     
     <li class="list-group-item" :class="className"v-if="msgimg" :id="id.id">
        <img :src="'storage/images/'+msgimg" width="180px" height="180px" class="img-responsive">
    </li>
     <li class="list-group-item" :class="className"><slot></slot></li>
  <small class="badge float-right" :class="badgeClass">@{{id.name}}</small>
  <small class="badge float-left" :class="badgeClass">{{moment(date).fromNow()}}</small>
 </div>

</template>

<script>
    export default {
        props:[

            'color','id','date','msgimg'
        ],
        data(){
            return{
                moment:moment,
                user:[],
            }
        },
      created(){
      //    axios.get(`/send/${this.id}`)
      //   .then(response => {
      // // console.log(response.data.data); 
      //  this.user = response.data.data;

      //   })
      //   .catch(error => {
      //     console.log(error);
      //   });
    },
        computed:{
            className(){
                return ' list-group-item-'+this.color;
            },
        badgeClass(){
                return ' badge-'+this.color;
        },

        },
        mounted() {
          //  console.log(this.id);

        },
        methods:{
         // moment: function (date) {
         //        return moment(date);
         //    },
        }

    }
</script>