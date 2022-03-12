<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Position extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'name_parent_case'
    ];

    protected $table = 'positions';

    public function users()
    {
        return $this->hasMany(User::class, 'position_id');
    }
}
