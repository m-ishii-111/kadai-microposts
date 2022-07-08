<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'micropost_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function micropost()
    {
        return $this->belongsTo(Micropost::class);
    }
}
