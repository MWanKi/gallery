<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
	{
	    return $this->hasOne('App\User', 'id', 'user_id');
	}

	public function article()
	{
	    return $this->belongsTo('App\Article');
	}
}
