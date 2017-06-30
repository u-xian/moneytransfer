<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Customers;
use Response;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = DB::table('Customers')
                    ->select('id','first_name','last_name','sex', 'nid','phone','dob','nationality','status','user_id')
                    ->get();
        return $customers;
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
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'phone' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'nationality' => 'required',
            'nid' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
      $dob = $request->year.'-'.$request->month.'-'.$request->day;
      $input = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'phone' => $request->phone,
            'dob' => $dob,
            'nationality' => $request->nationality,
            'nid' => $request->nid,
            'user_id' => $request->user_id,
        ];
        $customer = Customers::create($input);

        return 'Customer Created'.'  '.$customer['email'];
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
        $customer = Customers::where('id', '=', $id)
                         ->select('id','first_name','last_name','sex','phone','dob','nationality','status')
                         ->first();

        if(!$customer){
            return Response::json([
                'error' => [
                    'message' => 'Customer does not exist'
                ]
            ], 404);
        }
        return $customer;
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
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'nid' => 'required',
            'nationality' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);            
        }
        
        $customer = Customers::find($id);
        
        $customer->first_name  = $request->first_name;
        $customer->last_name  = $request->last_name;
        $customer->sex  = $request->sex;
        $customer->phone  = $request->phone;
        $customer->dob  = $request->dob;
        $customer->nid  = $request->nid;
        $customer->nationality  = $request->nationality;
        $customer->save(); 
 
        return Response::json([
                'message' => 'Customer Updated Succesfully'
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
        $customer = Customers::find($id);
        $customer->delete();

        return 'Successfully deleted the customer!';
    }
}