<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ClientMaster;
use Illuminate\Http\Request;

class ClientMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // FOR MAIN PAGE
    public function index()
    {
        try {
            $clients = ClientMaster::all();
            $clientNames = $clients->pluck('name')->map(function ($name) {
                return strtolower(str_replace(' ', '', $name));
            });
            $contact_number= $clients->pluck('contact_number');
            return view('clientmaster.index')->with([
                'clients' => $clients,
                'clientNames'=> $clientNames,
                'contact_number'=> $contact_number
            ]);
        }
        catch (Exception $e) {
            info($e);
            return redirect()->route("clientmaster.index")->with([
                "error" => "An error occurred: " . $e
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // DATA SAVE IN ADD DIALOG
    public function store(Request $request)
    {
        try {

            ClientMaster::create($request->only(ClientMaster::REQUEST_INPUTS));
            return response()->json('Client Details Added Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // DATA SHOW WHICH IS USED FOR EDIT AND SHOW

    public function show($client_no)
    {
     
      try {
            $clients = ClientMaster::findOrFail($client_no);
            return response()->json($clients);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $client_no
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $client_no
     * @return \Illuminate\Http\Response
     */

public function update(Request $request, $client_no)
{
    try {
        $clients = ClientMaster::findOrFail($client_no);
        $clients->update($request->only(ClientMaster::REQUEST_INPUTS));
        return response()->json('Client Details Updated Successfully');

    } catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the update', 400);
    }

}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $client_no
     * @return \Illuminate\Http\Response
     */
      public function destroy($client_no)
    {
        try {
            $clients = ClientMaster::findOrFail($client_no);
            $clients->delete();
            return response()->json('Client Details Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }
    }

}