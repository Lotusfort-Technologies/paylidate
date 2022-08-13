<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserBank;
use Illuminate\Validation\ValidationException;
use Auth;



class UserBankController extends Controller
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
        

        $request->validate([
            
            'account_name' => 'required|string|',
            'bank_name' => 'required|string|',
            'account_number' => 'required|max:10|min:10|unique:user_banks',
            'bank_code' => 'required|max:3|min:3',

        ]);
        


        try {

            if(!isset($request->branch_name)){
                $request['branch_name']   = 'null';
            }
            $request['user_id'] = auth('api')->user()->id;

            $user_bank = UserBank::create($request->all());

            if($user_bank){
                return response()->json([
                    'status' => 'success',
                    'message' => 'success',                    
                ]);
            }
            
                throw ValidationException::withMessages([
                    'error' => ['An error occured while trying to save bank details']
                ]);
            


           

        } catch (Exception $e) {
            return $e;
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $user_account = UserBank::where('user_id',$id)->first();
        if($user_account){
            return response()->json([
                'status' => 'success',
                'message' => 'success',
                'data' => $user_account
            ]);
        }

        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Account details not found',  
                'data' => null                  
            ]);
        }
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
        $request->validate([
            
            'account_name' => 'required|string|',
            'bank_name' => 'required|string|',
            'account_number' => 'required|max:10|min:10',
            'bank_code' => 'required|max:3|min:3',

        ]);

        if(!isset($request->branch_name)){
            $request['branch_name']   = 'null';
        }
        $user_id= auth('api')->user()->id;


        $updateUserBank = UserBank::where('user_id',$id)->update(['user_id'=>$user_id, 'account_name'=>$request->account_name,'branch_name'=>$request->branch_name, 'bank_name'=>$request->bank_name, 'account_number'=>$request->account_number, 'bank_code'=>$request->bank_code, ]);
    
        
        if($updateUserBank){
            return response()->json([
                'status' => 'success',
                'message' => 'Update successful',                    
            ]);
        }
        
            throw ValidationException::withMessages([
                'error' => ['An error occured while trying to update bank details']
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
}