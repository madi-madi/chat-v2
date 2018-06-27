@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-4 list-user">
            <div class="card">
                <div class="card-header">{{trans('chat.title')}} 
                  <button @click.prevent="openShow()" class="btn btn-success " type="button" style="float: right;" title="Create New Room">Create Room </button>
                  <create-room :open-modal="showView" @closemodal="close"></create-room>
                </div>

                <div class="card-body" style="position: relative;">
                    <div class="form-group" style="margin-bottom: unset; ">     
      
                <input type="text" placeholder="Search here New Rooms" 
                @keyup="search_room" v-model="roomName"  
                class="form-control"  name="room_Name" />

             
                     </div>
{{--                      <ul style="position: absolute;">
                         <li v-for="room in search_result"> @{{room.name }}</li>
                     </ul>
                    <ul class="list-group" > --}}
                       
                     <li class="list-group-item item-user" v-for="room,key in view_data" @click="openRoom(key,room.id)" :title="room.name"  >
                        <img src="https://scontent.fgza1-1.fna.fbcdn.net/v/t1.0-1/29066728_427456654335132_7484668120364220416_n.png?_nc_cat=0&_nc_eui2=v1%3AAeH7YF1fgHR2c1z4YFkkGRp7jaZKU-Fv1k2iJxVopXHA9EBgCRrFtSA09f6ngsXwPIm3nm9aFPtQo2yIjS4IFrdQD39xjGEBXUi2Q4XbGcYiFw&oh=fecb343ad9e1dd183b6e2e07f1f4f4be&oe=5B5D44C1" width="70px" height="70px" style="border-radius: 50%">
                        <a href="javascript:;"  >@{{room.name}}  
{{--                         <span 
                        class="badge badge-info lead float-right non-message"
                        :user_id = "{{auth()->user() ? 'false' : 'true'}}"
                        :title = "room"
                        >
                            @{{room.users.length}}
                           
                        </span> --}}
                        </a>  

                      </li>
                    
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8 list-messages">
            <div class="card">
                <div class="card-header"
                    :title="room_info == ''? 'Dashboard' : room_info.name"
                >@{{room_info == ''? 'Dashboard' : room_info.name }}  | 
                 <span class="badge-primary" v-if="typing[0]">@{{typing[0] }}...</span>
                 <span class="badge  float-right"
                    :class="room_info == ''?'' :'badge-info'"
                    :title= "room_info == ''? '' : room_info.users.length+ ' users'"
                    >  
                    @{{room_info == ''? '' : room_info.users.length+ ' users' }} 
                </span></div>

                    
                <div class="card-body"  v-chat-scroll="{always: false}">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                  
                <ul class="list-group" >
                    
                    <message-component
                     v-for="value in messages[0]" 
                     :key="value.index"
                      color="primary"
                      :id="value.user"
                      :msgimg="JSON.parse(value.message).image"
                      :date="value.created_at"
                       >
                        @{{JSON.parse(value.message).msg}}
                    </message-component>
                </ul>

                    

                </div>
                <div class="card-body overly" v-if="loading"></div>
                <a 
                href="javascript:;" 
                @click="join_room()"  
                class="btn btn-info"
                v-if="join_user"
                >Join</a>
                <div class="msg-area" style="position: relative;" >
                <ul class="list-group mention">
                    <li class="list-group-item" v-for="user,index in users"  @click="get_user_mention(index ,user.id)"><a href="javascript:;">@{{user.name}}</a></li>
                </ul>
                <form method="post" enctype="multipart/form-data"  v-on:submit.prevent="send()" id="mesg">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="room_id" :value="room_id">
                <input type="text" placeholder="Write your Message here!"  v-model="msgFrom"  class="form-control"  name="message" v-if="input_message"   />
                <input type="file" name="image" style="position: absolute;right: -100px;top: 4px;" v-if="input_message" ref="file" @change="getImage" id="image">
                </form>
    {{--             
                <span v-if="input_message"><i class="far fa-smile-plus"></i>


                    <picker 
                    set="messenger" 
                    showPreview="true" 
                    emojiSize="30"  
                   
                    showSkinTones="true"  />

<picker title="Pick your emoji…" emoji="point_up" />
<picker :style="{ position: 'absolute', bottom: '20px', right: '20px' }" />
<picker :i18n="{ search: 'Recherche', categories: { search: 'Résultats de recherche', recent: 'Récents' } }"/>
<emoji :emoji="{ id: 'santa', skin: 3 }" :size="16" />
                </span>
 --}}
                </div>
            </div>
        </div>

    </div>
</div>



@endsection
