<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
	 protected $fillable = ['name', 'image', 'user_id'];
	
    public function users()
    {
    	return $this->belongsToMany('App\User','room_user','room_id','user_id');
    }

        public function messages()
    {
        return $this->hasMany('App\Message','to','id');
    }
}

