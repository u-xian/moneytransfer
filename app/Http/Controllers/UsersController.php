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
        $input = $request->all();
        $rules = [
            'tos'=> 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ];

        $messages = [
            'tos.required' => 'You have to agree Terms and conditions',
            'email.required' => 'Please input your email address!',
            'email.email' => 'Email  is not valid.',
            'password.required' => 'Please input your password',
            'password.min' => 'Password should be 6 characters',
            'c_password.required' => 'Please input your password',
            'c_password.min' => 'Password should be 6 characters',
            'c_password.same' => 'Password and Re:password must match',
        ];


        $validator = Validator::make($input, $rules, $messages);

        
        if ($validator->fails()) {
            $messages = $validator->messages();
            
            return Response::json(['message' =>$messages],400);
        }

        $tos = json_decode($request->tos);
        if($tos === FALSE) {
             return "You have to agree Terms and conditions";   
        } 
       
        
        //$phone_complete  = $input['phone_prefix'].$input['phone'];
        //$input['phone'] = $phone_complete;

        //$user = Sentinel::registerAndActivate($input);
        $user = Sentinel::registerAndActivate($input);
        $userinfo = $this->show($user['id']);
        $outputs = [
                'id' => $user['id'],
                'email' => $user['email'],
                'status' => $user['status'],
            ];
        return $userinfo;
        
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
                         ->select('id','email','is_admin','status','created_at','updated_at')->first();

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
            return Response::json(['status' => true]); 
        }
        else
        {
            // Activation not found or not completed
            return Response::json(['status' => false]); 
        }         
    }


}
