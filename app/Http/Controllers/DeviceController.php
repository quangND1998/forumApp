<?php

namespace App\Http\Controllers;

use App\Models\device;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
class DeviceController extends Controller
{
    public function store(Request $request){
     
        $validator =  Validator::make($request->all(),   [
            'deviceID' => 'required|unique:devices,deviceID',
            'deviceName' => 'required',
        
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
       device::create([
            'deviceID' => $request->deviceID,
              'deviceName' => $request->deviceName
        ]);
        return response()->json('Create successfully', Response::HTTP_OK);
    }
}
