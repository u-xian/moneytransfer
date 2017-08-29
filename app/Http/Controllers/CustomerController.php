<?php

namespace App\Http\Controllers;

use App\ServicesRepo\Contracts\UploadFileRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Customers;
use Response;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use App\User;
use Activation;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    //
    protected $upfile;

    public function __construct(UploadFileRepositoryInterface $upfile)
    {
        $this->upfile = $upfile;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = DB::table('Customers')
                    ->select('id','first_name','last_name','sex', 'nid','phone','dob','nationality','customer_status','user_id')
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
            'prefix_code' =>'required',
            'phonenumber' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nationality' => 'required',
            'nid' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->messages()->all() as $error) {
                array_push($errors, $error);
            }
            return response()->json(['errors' => $errors, 'status' => 400], 400);            
        }
        
      $phone_complete  = $request->prefix_code.$request->phonenumber;
      $dob = $request->year.'-'.$request->month.'-'.$request->day;
      $input = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'phone' => $phone_complete ,
            'dob' => $dob,
            'nationality' => $request->nationality,
            'nid' => $request->nid,
            'user_id' => $request->user_id,
        ];

        $fname = $request->file('image_file');
        
        $customer = Customers::create($input);

        $result = $this->upfile->upload($fname,$customer['id']);
        
        $resp = [];
        if ($result['status']){
            $custinfo = $this->show($customer['id']);
            $resp = [
                'status' => true,
                'userid'=>$customer['user_id'],
                'custo_status' =>$custinfo['customer_status'], 
                'message'=>'Customer information received'
            ];
        }else{
            $resp = [
                'status' => False,
                'userid'=>$customer['user_id'],
                'message'=>$result['message']
            ];
        }
        
        return Response::json($resp);
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
         $customer = Customers::find($id);

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

    public function  isCustomer($id)
    {
        //
        $customer = Customers::where('user_id', '=', $id)
                            ->first();

        //$customer = Customers::find($id);
                            
        if(!$customer){
            return Response::json(['status' => false,'custo_status' =>'undefined']); 
        }
        else{
            return Response::json(['status' => true,'custo_status' =>$customer['customer_status']]); 
        }
    }

    public function  pending_Customers()
    {
        //
        $pending_customers= Customers::with('photos')
                            ->where('customer_status', '=', 0)
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(5);   
        return Response::json($pending_customers);     
    }

    public function activate_discard_customer($id , $action_type)
    {
        $customer = Customers::find($id);

        if($action_type == '1'){
            $cost_status = 1;
            $mess ='Customer activated Succesfully';
        } 
        elseif($action_type == '0'){
            $cost_status = 2;
            $mess ='Customer discarded Succesfully';
        }
        else{
            $cost_status = 0;
             $mess ='No change';
        }  
        $customer->customer_status  = $cost_status;
        $customer->save(); 
 
        return Response::json([
                'status' => true,
                'message' => $mess,
        ]);
    }
}