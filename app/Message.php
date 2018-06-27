<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

        protected $table = 'messages';
        protected $fillable = [
        'message', 'from', 'to'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','from');
    }

        public function users_seen()
    {
        return $this->hasMany('App\Read', 'message_id', 'id');
    }


    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
