<?php

namespace App\Http\Controllers;

use App\Models\Surcharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SurchargeController extends Controller
{

    public function getSurcharge()
    {
        return response()->json(['data' => Surcharge::all()]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'surcharge_rate' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json(['updated' => false, 'errors' => $validator->errors()]);
        }

        $rate = $request->surcharge_rate? $request->surcharge_rate : '0';

        // $Getsurcharge = Surcharge::all();
        // $surcharge = Surcharge::find($Getsurcharge[0]->id);

        $surcharge = Surcharge::where('id', '!=', '')->first();

        $surcharge->rate = $rate / 100;
        $surcharge->save();
        return response()->json(['updated' => true, 'message' => 'Surcharge has been successfully updated!']);
    }
}
