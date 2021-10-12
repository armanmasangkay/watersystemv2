<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Officer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public $officers_info = [];

    public function index()
    {
        $services = Service::where('status', 'finished')->get();
        $officers = Officer::all();
        
        foreach($officers as $officer){
            if($officer->position == Officer::$INTERNAL_AUDITOR_I)
            {
                $this->officers_info['auditor'] = [
                    'fullname_aud' => $officer->position == Officer::$INTERNAL_AUDITOR_I ? Str::title($officer->fullname) : '',
                    'position_aud' => $officer->position == Officer::$INTERNAL_AUDITOR_I ? $officer->prettyPosition() : '',
                ];
            }
            if($officer->position == Officer::$MUNICIPAL_ENGINEER)
            {
                $this->officers_info['engineer'] = [
                    'fullname_me' => $officer->position == Officer::$MUNICIPAL_ENGINEER ? Str::title($officer->fullname) : '',
                    'position_me' => $officer->position == Officer::$MUNICIPAL_ENGINEER ? $officer->prettyPosition() : '',
                ];
            }
        }

        return view('pages.work-order', ['services' => $services, 'officers' => $this->officers_info]);
    }

    public function filter(Request $request)
    {
        $services = Service::where('request_number', $request->request_number)->where('status', 'ready')->get();
        $officers = Officer::all();
        
        foreach($officers as $officer){
            if($officer->position == Officer::$INTERNAL_AUDITOR_I)
            {
                $this->officers_info['auditor'] = [
                    'fullname_aud' => $officer->position == Officer::$INTERNAL_AUDITOR_I ? Str::title($officer->fullname) : '',
                    'position_aud' => $officer->position == Officer::$INTERNAL_AUDITOR_I ? $officer->prettyPosition() : '',
                ];
            }
            if($officer->position == Officer::$MUNICIPAL_ENGINEER)
            {
                $this->officers_info['engineer'] = [
                    'fullname_me' => $officer->position == Officer::$MUNICIPAL_ENGINEER ? Str::title($officer->fullname) : '',
                    'position_me' => $officer->position == Officer::$MUNICIPAL_ENGINEER ? $officer->prettyPosition() : '',
                ];
            }
        }

        return view('pages.work-order', ['services' => $services, 'officers' => $this->officers_info]);
    }
}
