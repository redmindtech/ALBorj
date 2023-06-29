<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ClientMaster;
use App\Models\ProjectMaster;

use Illuminate\Http\Request;
require_once(app_path('constants.php'));
class ClientMasterController extends Controller
{
  
    // FOR MAIN PAGE
    public function index()
    {
        try {
            $emirates =SITELOCATION;
            if (session()->has('user')) {
            $clients = ClientMaster::where('deleted',0)->get();
            $clientNames = $clients->where('deleted', 0)
            ->pluck('name')
            ->map(function ($name) {
                return strtolower(str_replace(' ', '', $name));
            });
        
            $contact_number = $clients->where('deleted', 0)
            ->pluck('contact_number');
        
            return view('clientmaster.index')->with([
                'clients' => $clients,
                'clientNames'=> $clientNames,
                'contact_number'=> $contact_number,
                'emirates'=> $emirates
            ]);
        }else{
            return redirect("/");
        }
        }
        catch (Exception $e) {
            info($e);
            return redirect()->route("clientmaster.index")->with([
                "error" => "An error occurred: " . $e
            ]);
        }
    }

    // DATA SAVE IN ADD DIALOG
    public function store(Request $request)
    {
        $file = $request->file('attachments');
        try {

            $clients=ClientMaster::create($request->only(ClientMaster::REQUEST_INPUTS));
            if ($file) {
                $fileData = file_get_contents($file->getRealPath());
                $fileName = $file->getClientOriginalName();
      // Save the file data as a BLOB in the database
                $clients->attachments = $fileData;                
                $clients->filename = $fileName;
                $clients->save();
            }
            return response()->json('Client Details Added Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the store', 400);
        }

    }

    
// GET DATA FOR EDIT AND SHOW 
    public function show($client_no)
    {

      try {
            $clients = ClientMaster::findOrFail($client_no);
            if ($clients) {
                $clients = $clients->toArray();

                // Convert the data to UTF-8 encoding
                array_walk_recursive($clients, function (&$value) {
                    if (is_object($value)) {
                        $value = (array) $value; // Convert the stdClass object to an array
                    }

                    if (is_array($value)) {
                        array_walk_recursive($value, function (&$item) {
                            $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                        });
                    } else {
                        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                });
            }
            
            return response()->json($clients);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the show', 400);
        }
    }

    
    
// POST DATA FOR UPDATE 
public function update(Request $request, $client_no)
{
    try {
        $clients = ClientMaster::findOrFail($client_no);
        $clients->update($request->only(ClientMaster::REQUEST_INPUTS));
        // Check if the delete button was clicked and delete the attachments
        if ($request->has('delete_attachment') && $request->input('delete_attachment') === '1') {
            $clients->attachments = null;
            $clients->filename = null;
            $clients->save();
        }

        // Update the attachments if a new file is uploaded
        $file = $request->file('attachments');
        if ($file) {
            $fileData = file_get_contents($file->getRealPath());
            $fileName = $file->getClientOriginalName();

            $clients->attachments = $fileData;
            $clients->filename = $fileName;
            $clients->save();
        }
        return response()->json('Client Details Updated Successfully');

    } catch (Exception $e) {
        info($e);
        return response()->json('Error occured in the update', 400);
    }

}


//   DELETE FUNCTION
      public function destroy($client_no)
    {
        try {

            $clients = ClientMaster::findOrFail($client_no);
            $project = ProjectMaster::where('client_no', $client_no)->first();
            if ($project) {
            return response()->json('Cannot delete this client. It is associated with a project.', 200);
            }
            $clients->update(['deleted'=>'1']);
            return response()->json('Client Details Deleted Successfully', 200);

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }
    }
    

}