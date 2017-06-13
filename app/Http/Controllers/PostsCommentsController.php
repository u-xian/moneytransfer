<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\BlogPostComments;
use Carbon\Carbon;
use Response;

class PostsCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comments = BlogPostComments::all();
        return $comments;
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
            'on_post' => 'required',
            'names' => 'required',
            'email' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $input['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $input['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        $post = BlogPostComments::create($input);

        return 'Your comment added';
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
        //$comment = BlogPostComments::find($id);

        $comment = BlogPostComments::where('on_post', $id)
               ->orderBy('created_at')
               ->get();

        if(!$comment){
            return Response::json([
                'error' => [
                    'message' => 'Comment does not exist'
                ]
            ], 404);
        }
        return $comment;
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
            'on_post' => 'required',
            'from_user' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);            
        }
        
        $comment = BlogPostComments::find($id);
        
        $comment->on_post = $request->on_post;
        $comment->from_user = $request->from_user;
        $comment->body = $request->body;
        $comment->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $comment->save(); 
 
        return Response::json([
                'message' => 'Comment Updated Succesfully'
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
        $comment = BlogPostComments::find($id);
        $comment->delete();

        return 'Successfully deleted the comment!';
    }
}
