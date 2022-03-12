<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Organization extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'director_id', 'max_duration_of_vacation', 'min_duration_of_vacation'
    ];


    public function director()
    {
        return $this->belongsTo(User::class,'director_id');
    }
}
