<?php

namespace App\Http\Controllers\Client;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;
use App\Models\Client\ClientAgeGroup;

class ClientBabyagegroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        for($i = 0; $i < $request[1]; ++$i) {
            $formAgegroup = new ClientAgeGroup([
                'form_id' => $request[0][$i]["form_id"],
                'agegroup_id' => $request[0][$i]["agegroup_id"]
            ]);                    
            $formAgegroup->save();
        } 
        Cache::put('client_agegroups', ClientAgeGroup::all());       
        return $request[1];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ClientAgeGroup::where('form_id', '=', $id)->delete();
        Cache::put('client_agegroups', ClientAgeGroup::all());
        return response()->json('Удаление прошло успешно.');
    }
}
