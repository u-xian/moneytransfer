<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Currencies;
use Response;
use Illuminate\Support\Facades\Validator;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currencies = DB::table('currencies')
                    ->select('id','country','symbol','exchange_rate','phonecode')
                    ->paginate(5);
        return $currencies;
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
            'country' => 'required',
            'symbol' => 'required',
            'exchange_rate' => 'required',
            'phonecode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $currency = new Currencies;

        $currency->country = $request->country;
        $currency->symbol = $request->symbol;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->phonecode = $request->phonecode;

        $response = $currency->save();

        return Response::json($response);
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
        $currency = Currencies::find($id);

        if(!$currency){
            return Response::json([
                'error' => [
                    'message' => 'Currency does not exist'
                ]
            ], 404);
        }
        return $currency;
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
            'country' => 'required',
            'symbol' => 'required',
            'exchange_rate' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);            
        }
        
        $currency = Currencies::find($id);
        
        $currency->country  = $request->country;
        $currency->symbol  = $request->symbol;
        $currency->exchange_rate  = $request->exchange_rate;
        $currency->save(); 
 
        return Response::json([
                'message' => 'Currency Updated Succesfully'
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
        $currency = Currencies::find($id);
        $currency->delete();

        return 'Successfully deleted the currency!';
    }

     public function getAllCurrencies()
    {
        //
        $currencies = DB::table('currencies')
                    ->select('id','country','symbol','exchange_rate','phonecode')
                    ->get();
        return $currencies;
    }
}
