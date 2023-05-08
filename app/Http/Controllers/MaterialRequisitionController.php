<?php

namespace App\Http\Controllers;

use App\Models\MaterialRequisition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialRequisitionController extends Controller
{  /**
    * Display a material view
    *
    * 
    */
   public function index()
   {
   
       try{
           $projects = ProjectMaster::pluck('project_name');
            $items = ItemMaster::pluck('item_name');
           $materials = MaterialRequisition::with(['projects','users'])->get();
           

          return view('material.index', compact('projects','items','materials'));
       }catch(Exception $e){
           info($e);
           return redirect()->route('suppliermaster.index')->with('error', 'Error occured in the Material Requisition');
       }
   }


   public function getProjectCode(Request $request){
       try{
           $project_name = $request->input('project_name') ?? null;
           $data =  ProjectMaster::where('project_name', $project_name)->first();
           return response()->json($data);
       } catch(Exception $e){
           info($e);
           return response()->json('Error occured in the getProjectCode');
       }
   }


       public function getProjectItem(Request $request){
       try{
           $item_name = $request->input('item_name') ?? null;
           $data =  ItemMaster::where('item_name', $item_name)->first();
           return response()->json($data);
       } catch(Exception $e){
           info($e);
           return response()->json('Error occured in the getProjectCode');
       }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(MaterialRequest $request)
   {
       try{
           $data = $request->only(MaterialRequisition::REQUEST_INPUTS);
           $data['user_id'] = 2;
           $material = MaterialRequisition::create($data);
           $material_items = $request->input('item_no') ?? null;
           $quantity = $request->input('quantity') ?? null;
           if(count($material_items) > 0){
               foreach($material_items as $key => $material_item){
                   MaterialRequisitionItem::create([
                    'material_id' => $material->id,
                    'item_id' => $material_item,
                    'quantity' => $quantity[$key]
                   ]);
               }
           }

           return response()->json('Material Requisition is created Successfully');

       } catch(Exception $e){
           info($e);
           return response()->json('Error occured in material store');
       }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       try{
           $material = MaterialRequisition::with(['projects','material_items.items'])->findOrFail($id);
           return $material;

       } catch(Exception $e){
           info($e);
           return response()->json('Error occured in the material show');
       }
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
   public function destroy($id)
   {
   
       try{
           $material = MaterialRequisition::findOrFail($id);
           $material->delete();
           $material_items = MaterialRequisitionItem::where('material_id', $id)->get();
           foreach($material_items as $material_item){
               $material_item->delete();
           }
           return response()->json('Material Deleted Successfully');

       }catch(Exception $e){
           info($e);
           return response()->json('Error occured in material destroy');
       }
   }

    }
