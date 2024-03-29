<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password' , 'phone_number' , 'permission' , 'national_identity',
//        'social_insurance_number' , 'gender' , 'data_subscribe_social'
//    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    protected $dates = ['data_subscribe_social'];



    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function letters()
    {
        return $this->hasMany(Letter::class)->orderBy('id' , 'DESC');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class)->orderBy('id' , 'DESC');
    }

    public function files()
    {
        return $this->hasMany(File::class)->orderBy('id' , 'DESC');
    }


    public function my_demands()
    {
        return $this->hasMany(Demand::class)->orderBy('id' , 'DESC');
    }


    public function demands()
    {
        return $this->belongsToMany(Demand::class)->withTimestamps()->orderBy('id' , 'DESC');
    }

    public function my_events()
    {
        return $this->hasMany(Event::class);
    }



//    public function events()
//    {
//        return $this->hasMany(Event::class);
//    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->orderBy('id' , 'DESC');
    }

    public function commits()
    {
        return $this->hasMany(Commit::class);
    }


    public function common_events()
    {
        return $this->belongsToMany(Event::class)->withTimestamps();
    }


}
