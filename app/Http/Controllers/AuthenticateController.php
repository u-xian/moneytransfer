<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Customers;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Reminder;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Response;

class AuthenticateController extends Controller
{
    //
     /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
            
            $outputs = [];
            //check login details
            if($user = Sentinel::authenticate($credentials))
            {
                $userdetails = Sentinel::findById($user['id']);
                $login = Sentinel::login($userdetails);
                $customer = Customers::where('user_id', '=', $login['id'])->first();
                $outputs = [
                    'id'=> $login['id'],
                    'email' => $login['email'], 
                    'is_admin' => ($login['is_admin'] > 0 ? true : false),
                    'customer_id' => $customer['id'],
                    'status' => true,
                    'message'=>'Account activated.'
                ];
            }
            else
            {
               $outputs = [
                    'status' => false,
                    'message'=>'Invalid email or password. Please try again'
                ];  
            }
            

            return Response::json($outputs); 

            
           
           
        }     
        catch (NotActivatedException $e) {
            return Response::json(['status' => false,'message'=>'Account not activated.']); 
        }
    }

    //
     /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        	'first_name' => 'required',
        	'last_name' => 'required',
        	'sex' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $user = Sentinel::registerAndActivate($input);
        $outputs = [
                'first_name'=> $user['first_name'],
                'last_name'=> $user['last_name'],
                'email' => $user['email'],
                'status' => $user['status'],
            ];
        return $outputs;
    }

    public function show($id)
    {
    	// get the user
        $user = User::where('id', '=', $id)
                         ->select('id','first_name', 'last_name','sex')->first();

        // show the edit form and pass the nerd
        return $user;
    }

    public function update(Request $request, $id)
    {
    	$user = Sentinel::findById($id);

        $credentials = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'sex' => $request->input('sex'),
        ];

        $user = Sentinel::update($user, $credentials);
 
        return Response::json([
                'message' => 'User Updated Succesfully'
        ]);
    }

    public function suspendReactivate(Request $request, $id)
    {
    	$user = Sentinel::findById($id);

        $credentials = [
            'status' => $request->input('status'),
        ];

        $user = Sentinel::update($user, $credentials);

        if ($request->input('status')==0)
        {
           $responsemsg = 'User Suspended Succesfully';
        }
        else 
        {
           $responsemsg = 'User Reactivated Succesfully';
        }

        return Response::json([
                'message' => $responsemsg
        ]);
    }

    public function resetPassword(Request $request, $id)
    {
        $hasher = Sentinel::getHasher();

    	$oldPassword = $request->input('old_password');
        $password = $request->input('password');
        $passwordConf =  $request->input('password_confirmation');

        $user = Sentinel::findById($id);

        if (!$hasher->check($oldPassword, $user->password) || $password != $passwordConf) {
            return Response::json([
                'message' => 'Check input is correct.'
            ]);
        }
        
        $rem_create = Reminder::create($user);

        $check_rem = Reminder::exists($user);

        if ($reminder = Reminder::complete($user, $rem_create['code'], $password))
        {
            // Reminder was successfull
            return Response::json([
                'message' => 'Password reset successfuly'
                ]);
        }
        else
        {
            // Reminder not found or not completed.
            return Response::json([
                'message' => 'Password reset failed'
                ]);
        }    
    }
}
