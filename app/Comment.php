<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'post_id',
        'text'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function post()
    {
        return $this->belongsTo('App\Post');
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
