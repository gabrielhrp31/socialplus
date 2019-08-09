<?php

use Illuminate\Http\Request;

use App\User;
use App\Comment;
use App\Post;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');

Route::middleware('auth:api','cors')->group(function () {

    Route::put ('user/update', 'API\UserController@update');

    Route::post('checkLogin', 'API\AuthController@checkLogin');

    Route::get('posts', 'API\PostController@list');

    Route::post('post/create', 'API\PostController@create');

    Route::put('post/like', 'API\PostController@like');

    Route::post('post/comment', 'API\PostController@comment');

    Route::post('post/comment/delete', 'API\PostController@deleteComment');
});

Route::get('/testes',function (){
    $user1 = User::all()->last();
    $user2 = User::all()->first();
    $posts = Post::with('comments','user')->orderBy('created_at', 'desc')->paginate(5);

    foreach ($posts as $post){
        dd($post->comments);
    }

    //CRIAR POST
    /* $user1->posts()->create([
        'title'=>'Conteudo 1',
        'text'=>'Aqui um texto',
        'image'=>'url da imagem',
        'link'=>'link'
    ]);

    //ADICIONAR/REMOVER AMIGO
    $user1->friends()->toggle($user2->id);

    //CURTIR/DESCURTIR
    $user1->likes()->toggle($post->id);
    //QUantidade de Curtidas
    $post->likes()->count();
    ADicionar Comentarios
    $user2->comments()->create([
       'post_id'=>$post->id,
        'text'=>'Um Lixo!'
    ]);
    */


//    $user2->comments()->create([
//        'post_id'=>$post->id,
//        'text'=>'Bacaninha!'
//    ]);


    return $post;
});