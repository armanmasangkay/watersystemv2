<?php

namespace App\Http\Controllers;

use App\Http\Requests\services\StoreServiceRequest;
use App\Models\Customer;
use App\Models\Service;
use App\Rules\RedundantService;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ServiceController extends Controller
{

    private function getServices()
    {
        return Arr::except(Service::getServiceTypes(),['new_connection']);
    }


    public function index()
    {
        $services = Service::paginate(15);
        $status = Service::getServiceStatus();

        return view('pages.services-list', [
            'services' => $services,
            'status' => $status
        ]);
    }

    public function filter(Request $request){

        if($request->from!=null ||  $request->to!=null){

            $validator=validator($request->all(),[
                'from'=>'required_with:to|before_or_equal:to',
                'to'=>'required_with:from',
            ]);
    
            if($validator->fails()){
                return redirect(route('admin.services.index',[
                    'filter'=>$request->filter
                ]))->withErrors($validator->errors())->with([
                    'from'=>$request->from,
                    'to'=>$request->to,
                ]);
            }
            
        }
        

        if($request->filter == 'none'){
            return redirect(route('admin.services.index'));
        }

        $from=$request->from;

        $to=Carbon::parse($request->to)->addDay(1)->format("Y-m-d");

        $services = Service::where('status', $request->filter)
                    ->whereBetween('created_at',[$from ?? '',$to ?? ''])        
                    ->paginate(10);
         
        $status = Service::getServiceStatus();
        return view('pages.services-list', [
            'services' => $services,
            'status' => $status,
            'from'=>$request->from,
            'to'=>$request->to
        ]);

    }

    public function search(Request $request)
    {
       
        try{
            $customer= Customer::findOrFail($request->account_number);
           
            return view('pages.add-service', [
                'route' => 'admin.search-customer',
                'services'=>$this->getServices(),
                'customer'=>$customer
            ]);
        }catch(ModelNotFoundException $e){
            return redirect(route('admin.services.create'))->withErrors([
                    'account_number'=>'Account number not found!'
                ])->withInput();
        } 

    }


    public function create()
    {
        return view('pages.add-service', [
            'route' => 'admin.search-customer',
            'services'=>$this->getServices()
        ]);
    }


    public function store(StoreServiceRequest $request)
    {
       $initialStatus=Service::getInitialStatus($request->service_type);
       Service::create([
            'customer_id'=>$request->account_number,
            'type_of_service'=>$request->service_type,
            'remarks'=>$request->remarks,
            'landmarks'=>$request->landmark,
            'work_schedule'=>$request->service_schedule,
            'status'=>$initialStatus,
            'start_status'=>$initialStatus,
            'request_number'=>Service::generateUniqueIdentifier()
       ]);

       return back()->with([
           'created'=>true,
           'message'=>'A service was successfully created for this customer!'
       ]);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return back();
    }
}
