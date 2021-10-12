<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Officer;
use Illuminate\Support\Str;

class WorkOrderController extends Controller
{
    public $officers_info = [];

    public function index()
    {
        $services = Service::where('status', 'finished')->get();
        $officers = Officer::where("position", Officer::$INTERNAL_AUDITOR_I)->where("position", Officer::$MUNICIPAL_ENGINEER)->get();

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

        $auditor = Officer::where("position", Officer::$INTERNAL_AUDITOR_I)->get();
        $engineer = Officer::where("position", Officer::$MUNICIPAL_ENGINEER)->get();
        $msg = ($auditor == null ? 'Internal Auditor I' : null) .', '. ($engineer == null ? 'Municipal Engineer' : null);

        if($msg == ", ")
        {
            return redirect(route('admin.officers.create'))->with('msg', 'You need to create these account(s) '. $msg .' in order to continue');
        }
        
        $officers = Officer::where("position", Officer::$INTERNAL_AUDITOR_I)->where("position", Officer::$MUNICIPAL_ENGINEER)->get();
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
