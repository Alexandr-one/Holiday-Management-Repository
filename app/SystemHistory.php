<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemHistory extends Model
{
    /** @var string[] */
    protected $fillable = [
        'name',
        'user_id',
        'last_value',
        'new_value'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
