<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $table = 'demands';

    protected $guarded = [];




    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

}
