<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaterRate;

class WaterRateController extends Controller
{
    public function update(Request $request)
    {
        $requestData = $request->all();

        $requestData['min_rate'] = $requestData['min_rate'] ? $requestData['min_rate'] : '0';
        $requestData['excess_rate'] = $requestData['excess_rate'] ? $requestData['excess_rate'] : '0';

        $water_rate = WaterRate::find($requestData['type']);

        $water_rate->min_rate = $requestData['min_rate'];
        $water_rate->excess_rate = $requestData['excess_rate'];
        $water_rate->save();

        return redirect(route('admin.dashboard'));
    }
}
