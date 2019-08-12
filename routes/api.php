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

Route::middleware('auth:api')->group(function () {


    Route::post('checkLogin', 'API\AuthController@checkLogin');


    Route::prefix('user')->group(function (){
        Route::put ('update', 'API\UserController@update');

        Route::get('{id?}', 'API\UserController@profile');

        Route::post('find', 'API\UserController@find');

        Route::post('follow/{id}', 'API\UserController@follow');

        Route::post('followOnly/{id}/{idUserPage?}', 'API\UserController@followOnly');
    });


    Route::prefix('posts')->group(function (){

        Route::get('', 'API\PostController@list');

    });


    Route::prefix('post')->group(function () {
        Route::post('create', 'API\PostController@create');

        Route::put('like', 'API\PostController@like');

        Route::post('comment', 'API\PostController@comment');

        Route::post('comment/delete', 'API\PostController@deleteComment');
    });
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