<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Countries;
use Response;
use Illuminate\Support\Facades\Validator;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $countries = DB::table('countries')
                    ->select('id','iso_abbr','name','nicename','iso_name','numcode','phonecode')
                    ->paginate(5);
        return $countries;
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
            'iso_abbr'=> 'required',
            'nicename'=> 'required',
            'iso_name'=> 'required',
            'numcode'=> 'required',
            'phonecode'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $country = new Countries;

        $country->iso_abbr = $request->iso_abbr;
        $country->name = $request->nicename;
        $country->nicename = $request->nicename;
        $country->iso_name = $request->iso_name;
        $country->numcode = $request->numcode;
        $country->phonecode = $request->phonecode;

        $response = $country->save();

        return Response::json($response);
        
        /*
        $input = $request->all();
        $country = Countries::create($input);

        return 'Country created'.'  '.$country['name'];*/
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
        $country = Countries::find($id);

        if(!$country){
            return Response::json([
                'error' => [
                    'message' => 'Country does not exist'
                ]
            ], 404);
        }
        return $country;
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
            'iso_abbr'=> 'required',
            'name'=> 'required',
            'nicename'=> 'required',
            'iso_name'=> 'required',
            'numcode'=> 'required',
            'phonecode'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);            
        }
        
        $country = Countries::find($id);
        
        $country->iso_abbr  = $request->iso_abbr;
        $country->name  = $request->name;
        $country->nicename  = $request->nicename;
        $country->iso_name  = $request->iso_name;
        $country->numcode  = $request->numcode;
        $country->phonecode  = $request->phonecode;
        $country->save(); 
 
        return Response::json([
                'message' => 'Country Updated Succesfully'
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
        $country = Countries::find($id);
        $country->delete();

        return 'Successfully deleted the country!';
    }

    public function getAllCountries()
    {
        //
        $countries = DB::table('countries')
                    ->select('id','iso_abbr','name','nicename','iso_name','numcode','phonecode')
                    ->get();
        return $countries;
    }
}
