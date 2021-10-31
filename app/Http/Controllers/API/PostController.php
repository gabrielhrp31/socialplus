<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    protected function reverseComents($posts){
        if(is_array($posts)){
            foreach ($posts as $post){
                $post->comments = array_reverse($post->comments);
            }
        }else{
            $posts->comments = array_reverse($posts->comments);
        }
    }


    public function create(Request $request){

        //lembrar de mudar o fuso horário

        $data = $request->all();
        $user = $request->user();


        $validation = Validator::make($data, [
            'title' => ['required'],
            'text' => ['required']
        ]);

        if($validation->fails()){
            return ['success'=>false, 'validation'=>$validation->errors()];
        }

        $user->posts()->create([
            'title'=>$data['title'],
            'text'=>$data['text'],
            'image'=>$data['image'],
            'link'=>$data['link'],
        ]);

//        Post::all()->last()->delete();

        $posts = Post::withCount('likes', 'comments')
            ->with('user', 'likes',  'comments', 'comments.user')
            ->leftJoin('follows','follows.follow_id','=','posts.user_id')
            ->where('posts.user_id',$user->id)
            ->orWhere('follows.user_id',$user->id)
            ->orderBy('created_at', 'desc')->paginate(5);


        $this->liked($posts,$user);

        return ['status'=>true, 'posts'=>$posts];
    }

    public function delete(Request $request, $id){
        $data = $request->all();

        $user = $request->user();


        $post = Post::find($id);

        $post->delete();

        $posts = Post::withCount('likes', 'comments')
            ->with('user', 'likes',  'comments', 'comments.user')
            ->leftJoin('follows','follows.follow_id','=','posts.user_id')
            ->where('posts.user_id',$user->id)
            ->orWhere('follows.user_id',$user->id)
            ->orderBy('created_at', 'desc')->paginate(5);
        $this->liked($posts,$user);
        return ['status'=>true, 'posts'=>$posts];
    }

    public function list(Request $request){

        $user = $request->user();

        $posts = Post::withCount('likes', 'comments')
            ->with('user', 'likes',  'comments', 'comments.user')
            ->leftJoin('follows','follows.follow_id','=','posts.user_id')
            ->where('follows.user_id',$user->id)
            ->orWhere('posts.user_id',$user->id)
            ->orderBy('created_at', 'desc')->paginate(5);
        $this->liked($posts,$user);
        return ['status'=>true, 'posts'=>$posts];
    }

    public function like(Request $request){
        $data = $request->all();
        $user = User::find($data['user_id']);
        $post = Post::find($data['post_id']);

        if($post){

            $user->likes()->toggle($post->id);

            $post = Post::withCount('likes', 'comments')->with('user', 'likes', 'comments', 'comments.user')->find($data['post_id']);

            $liked  = DB::table('likes')->where([
                ['user_id', '=', $user->id],
                ['post_id', '=', $post->id]
            ])->count();

            if($liked){
                $post->liked = true;
            }else{
                $post->liked = false;
            }

            return ['status'=>true, 'post'=>$post];
        }else{
            return ['status'=>false, 'message'=>'O conteudo nn existe'];
        }



    }

    public function comment(Request $request){
        $data = $request->all();
        $user = User::find($data['user_id']);
        $post = Post::find($data['post_id']);

        if($post){

            $user->comments()->create([
                'post_id'=>$post->id,
                'text'=>$data['text']
            ]);

            $post = Post::withCount('likes', 'comments')->with('user', 'likes', 'comments', 'comments.user')->find($data['post_id']);

            return ['status'=>true, 'post'=>$post];
        }else{
            return ['status'=>false, 'message'=>'O conteudo nn existe'];
        }
    }



    public function deleteComment(Request $request){
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);

        $data['post_id'] = $comment->post_id;
        $comment = $comment->delete();

        $post = Post::withCount('likes', 'comments')->with('user', 'likes', 'comments', 'comments.user')->find($data['post_id']);

        if($comment){
            return ['status'=>true, 'post'=> $post];
        }else{
            return ['status'=>false, 'message'=>'O conteudo nn existe'];
        }
    }

    private function liked($posts, $user){
        foreach ($posts as $post){
            $liked  =  DB::table('likes')->where([
                ['user_id', '=', $user->id],
                ['post_id', '=', $post->id]
            ])->count();
            if($liked){
                $post->liked = $liked;
            }else{
                $post->liked = $liked;
            }
        }
    }
}
