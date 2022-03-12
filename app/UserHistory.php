<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    /** @var string[] */
    protected $fillable = [
        'name',
        'auth_id',
        'user_id',
        'last_value',
        'new_value'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function auth()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }

}
