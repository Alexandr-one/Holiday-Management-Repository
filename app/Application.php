<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Application extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'date_start', 'date_finish', 'status', 'number_of_days', 'comment'
    ];


    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
