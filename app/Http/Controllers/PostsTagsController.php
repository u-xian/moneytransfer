<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\BlogPostTag;
use Carbon\Carbon;
use Response;

class PostsTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $poststags = BlogPostTag::all();
        return $poststags;
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
            'post_id' => 'required',
            'tag_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $input['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $input['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        $poststags = BlogPostTag::create($input);

        return 'Tag added';
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
        $poststag = BlogPostTag::find($id);

        if(!$poststag){
            return Response::json([
                'error' => [
                    'message' => 'Post Tag does not exist'
                ]
            ], 404);
        }
        return $poststag;
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
            'post_id' => 'required',
            'tag_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);            
        }
        
        $poststag = BlogPostTag::find($id);
        
        $poststag->post_id  = $request->post_id;
        $poststag->tag_id = $request->tag_id;
        $poststag->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $poststag->save(); 
 
        return Response::json([
                'message' => 'Post Tag Updated Succesfully'
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
        $poststag = BlogPostTag::find($id);
        $poststag->delete();

        return 'Successfully deleted the post tag!';
    }
}
