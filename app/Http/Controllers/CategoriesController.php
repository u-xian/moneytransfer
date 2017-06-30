<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\BlogCategory;
use Response;



class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$categories = BlogCategory::all();
        
        $categories = DB::select('select a.category,count(b.id) as ct  from blog_categories a, posts b  where a.id=b.category_id group by a.category');

        return $categories;

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
            'category'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $input['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        $category = BlogCategory::create($input);

        return 'Category  created'.'  '.$category['category'];
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
        $category = BlogCategory::find($id);

        if(!$category){
            return Response::json([
                'error' => [
                    'message' => 'Category does not exist'
                ]
            ], 404);
        }
        return $category;
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
            'category'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);            
        }
        
        $category = BlogCategory::find($id);
        
        $category->category  = $request->category;
        $category->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $category->save(); 
 
        return Response::json([
                'message' => 'Category Updated Succesfully'
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
        $category = BlogCategory::find($id);
        $category->delete();

        return 'Successfully deleted the category!';
    }
}
