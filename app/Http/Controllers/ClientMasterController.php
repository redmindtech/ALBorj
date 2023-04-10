<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use App\Models\ClientMaster;

use Illuminate\Http\Request;

class ClientMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = ClientMaster::all();
        return view('clientmaster.index')->with([
            'clients' => $clients
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientmaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [


            'client_no'=>'',
            'name' => 'required',
            'company_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',

        ]);
        $data = $request->except(['_token']);
        ClientMaster::create($data);
        return redirect()->route("clientmaster.index")->with([
            "success" => "client added successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $client_no
     * @return \Illuminate\Http\Response
     */
    public function show($client_no)
    {
        $client = ClientMaster::where('id', $client_no)->first();
        return view("clientmaster.show")->with([
            "clients" => $client
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $client_no
     * @return \Illuminate\Http\Response
     */
    public function edit($client_no)
    {
        $client =ClientMaster::find($client_no);
        return view('clientmaster.index',['clients' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $client_no
     * @return \Illuminate\Http\Response
     */
    public function client_data()
    {
        // info('edit');
        $client_no=$_GET['id'];
        // info($client_no);
        $data = ClientMaster::where('client_no',$client_no)->get();
        // info($data);
        return $data;


   }
    public function update(Request $request, $client_no)
    {
        // info($request['client_no']);
        $client = ClientMaster::where('client_no', $request['client_no']);
        $this->validate($request, [
            'name' => 'required',
            'company_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',

        ]);
        $input = $request->except(['_token', '_method']);
        $client->update($input);
        return redirect()->route("clientmaster.index")->with([
            "success" => "clientmaster updated successfully"
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $client_no
     * @return \Illuminate\Http\Response
     */
    public function destroy($client_no)
    {
        $client = ClientMaster::where('client_no', $client_no);
        $client->delete();
        return redirect()->route("clientmaster.index")->with([
            "success" => "Client deleted successfully"
        ]);
    }
}
