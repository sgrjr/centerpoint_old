<?php namespace App\Http\Controllers\Api\v1\inventory;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\BaseController as BaseController;
use App\Inventory;
use Validator;
use App\Http\Resources\Inventory as InventoryResource;
   
class InventoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = Inventory::all();
    
        return $this->sendResponse(InventoryResource::collection($inventory), 'Inventory retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $inventory = Inventory::create($input);
   
        return $this->sendResponse(new InventoryResource($inventory), 'Inventory created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = Inventory::find($id);
  
        if (is_null($inventory)) {
            return $this->sendError('Inventory item not found.');
        }
   
        return $this->sendResponse(new InventoryResource($inventory), 'Inventory item retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $inventory->name = $input['name'];
        $inventory->detail = $input['detail'];
        $inventory->save();
   
        return $this->sendResponse(new InventoryResource($inventory), 'Inventory updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
   
        return $this->sendResponse([], 'Inventory deleted successfully.');
    }
}