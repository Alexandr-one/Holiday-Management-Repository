<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ApplicationStatusHistory extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'application_id', 'new_value', 'last_value'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
