<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Post extends Model
{
    protected $fillable = [
        'title',
        'text',
        'image',
        'link'
    ];




    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function likes(){
        return $this->belongsToMany('App\User', 'likes', 'post_id', 'user_id');
    }

    public function getCreatedAtAttribute($value){
        $secondsNow = (Integer) date('U');
        $seconds = (Integer) date('U', strtotime($value));
        $result =  $secondsNow - $seconds;


        if($result>86400){

            $months=['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

            $month = (Integer)date('n', strtotime($value));

            $month = $months[$month-1];

            return date('d', strtotime($value))
                .' de '
                .$month
                .' às '
                .date('H:i', strtotime($value));
        }else{
            if($result<60){
                return 'Há alguns segundos';
            }else if($result<3600){
                return 'Há '.ceil($result/60).' minutos';
            }else if($result<86400){
                return 'Há '.ceil($result/3600).' horas';
            }else if($result==86400){
                return 'Há '.ceil($result/86400).' dia';
            }
        }
    }
}
