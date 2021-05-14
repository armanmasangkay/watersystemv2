<?php

namespace App\Http\Controllers;

use App\Models\Surcharge;
use Illuminate\Http\Request;

class SurchargeController extends Controller
{
    public function update(Request $request)
    {
        $rate = $request->rate? $request->rate : '0';

        $surcharge = Surcharge::find(1);

        $surcharge->rate = $rate;
        $surcharge->save();
        return redirect(route('admin.dashboard'));
    }
}
