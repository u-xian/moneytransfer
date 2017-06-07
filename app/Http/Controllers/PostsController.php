<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Post;
use Carbon\Carbon;
use Response;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        //$post = Post::all();

        $post= Post::select(['id','url','title','description','content','image','author_id','created_at'])
                ->with(['author' =>function ($q) {
                            $q->select(['id','first_name','last_name']);
                        }, 
                        'comments' => function ($query) {
                            $query->select(['id','body','created_at','names','email','on_post']);
                        }])
                ->get();

        return $post;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $input['url'] = str_slug($request->title);
        $input['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $input['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        $post = Post::create($input);

        return 'Post Created'.'  '.$post['title'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //$post = Post::find($id);
        //$post= Post::with('author','comments')->find($id);

        $post= Post::select(['id','url','title','description','content','image','author_id','created_at'])
                ->with(['author' =>function ($q) {
                            $q->select(['id','first_name','last_name']);
                        }, 
                        'comments' => function ($query) {
                            $query->select(['id','body','created_at','names','email','on_post']);
                        }])
                ->find($id);


        /*$post = Post::select(['id','url','title','description','content','image','created_at'])
                   ->with(['comments' => function($q){
                        $q->select(['id','body','created_at','names','email','on_post']);
                    }])
                   ->with(['author' => function($r){
                        $r->select(['id','first_name']);
                    }])->find($id);*/



        if(!$post){
            return Response::json([
                'error' => [
                    'message' => 'Post does not exist'
                ]
            ], 404);
        }
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);            
        }
        
        $tag = Post::find($id);
        
        $tag->url  = str_slug($request->title);
        $tag->title = $request->title;
        $tag->description = $request->description;
        $tag->content = $request->content;
        $tag->category_id = $request->category_id;
        $tag->author_id = $request->author_id;
        $tag->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $tag->save(); 
 
        return Response::json([
                'message' => 'Post Updated Succesfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tag = Post::find($id);
        $tag->delete();

        return 'Successfully deleted the post!';
    }
}
