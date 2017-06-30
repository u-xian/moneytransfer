<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use App\User;
use Activation;
use Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'tos'=> 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $tos = json_decode($request->tos);
        if($tos === FALSE) {
             return "You have to agree Terms and conditions";   
        } 
       
        $input = $request->all();
        //$phone_complete  = $input['phone_prefix'].$input['phone'];
        //$input['phone'] = $phone_complete;

        //$user = Sentinel::registerAndActivate($input);
        $user = Sentinel::register($input);
        /*$outputs = [
                'first_name'=> $user['first_name'],
                'last_name'=> $user['last_name'],
                'email' => $user['email'],
                'status' => $user['status'],
            ];*/
        return $user;
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
        // get the user
        $user = User::where('id', '=', $id)
                         ->select('id','first_name', 'last_name','phone','email')->first();

        // show the edit form and pass the nerd
        return $user;
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
        $user = Sentinel::findById($id);

        $credentials = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
        ];

        $user = Sentinel::update($user, $credentials);
 
        return Response::json([
                'message' => 'User Updated Succesfully'
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
    }
    
    public function activate($id){
        //
        $user = Sentinel::findById($id);
        $activation = Activation::create($user);

        if (Activation::complete($user, $activation['code']))
        {
             // Activation was successfull
            $rsp = 1;
        }
        else
        {
             // Activation not found or not completed.
            $rsp = 0;
        } 
        return Response::json(['status' => $rsp]);

    }
    public function isActivated($id)
    {
        // 
        $user = Sentinel::findById($id);
        if ($activation = Activation::completed($user))
        {
            // User has completed the activation process
            return Response::json(['status' => '1']); 
        }
        else
        {
            // Activation not found or not completed
            return Response::json(['status' => '0']); 
        }         
    }


}
