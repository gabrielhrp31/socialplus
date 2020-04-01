<?php

namespace App;

use function GuzzleHttp\Psr7\str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be appended to class, its virtual attribute
     *
     * @var array
     */
    protected $appends = [
        'image_path',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function comments()
    {
        return $this->hasMany('App\Comment');
    }


    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function likes(){
        return $this->belongsToMany('App\Post', 'likes', 'user_id', 'post_id');
    }

    public function followed(){
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'follow_id');
    }

    public function followers(){
        return $this->belongsToMany('App\User', 'follows', 'follow_id', 'user_id');
    }

    public function getImageAttribute($value){
        if(!file_exists($value)) {
            return asset('default.jpg');
        }
        return (asset($value)??asset('default.jpg'));
    }

    public function getImagePathAttribute(){
        return str_replace(asset(''),'',$this->image);
    }
}
