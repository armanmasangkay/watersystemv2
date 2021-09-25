<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficerRequest;
use App\Models\Officer;
use Illuminate\Support\Str;

class OfficerController extends Controller
{
    public function index()
    {
        return view('pages.officers.index',[
            'officers' => Officer::paginate(20)
        ]);
    }

    public function create()
    {
        return view('pages.officers.create',[
            'positions' => Officer::getPositions()
        ]);
    }

    public function store(OfficerRequest $request)
    {

        Officer::create([
            'fullname' => Str::title($request->fullname),
            'position' => $request->position
        ]);

        return redirect(route('admin.officers.index'))->with([
            'created' => true,
            'message' => 'New Officer has been successfully added!'
        ]);
    }

    public function edit(Officer $officer)
    {
        $officer = Officer::findOrFail($officer->id);

        return view('pages.officers.edit',[
            'officer' => $officer,
            'positions' => Officer::getPositions()
        ]);
    }

    public function update(OfficerRequest $request, Officer $officer)
    {

        $officer = Officer::findOrFail($officer->id);

        $officer->fullname = Str::title($request->fullname);
        $officer->position = $request->position;
        $officer->save();

        return redirect(route('admin.officers.index'))->with([
            'created' => true,
            'message' => 'Officer has been successfully updated!'
        ]);
    }

    public function destroy(Officer $officer)
    {
        $officer->delete();

        return redirect(route('admin.officers.index'))->with([
            'created' => true,
            'message' => 'Officer has been successfully deleted!'
        ]);
    }
}
