<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $table = 'letters';

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
