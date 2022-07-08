<?php

namespace App\Http\Controllers;

use App\Events\ActiveDevice;
use App\Models\device;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function store(Request $request)
    {

        // $validator =  Validator::make($request->all(),   [
        //     'deviceID' => 'required|unique:devices,deviceID',
        //     'deviceName' => 'required',

        // ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        // }
        $device = device::where('deviceID', $request->deviceID)->first();
        if ($device) {
            $device->update([
                'deviceID' => $request->deviceID,
                'deviceName' => $request->deviceName,
                'serial' => $request->serial,
                'state' => $request->state,
                'os_version' => $request->os_version,
                'battery' => $request->battery
            ]);
            broadcast(new ActiveDevice($device))->toOthers();
        } else {
            $device = device::create([
                'deviceID' => $request->deviceID,
                'deviceName' => $request->deviceName,
                'serial' => $request->serial,
                'state' => $request->state,
                'os_version' => $request->os_version,
                'battery' => $request->battery
            ]);
            broadcast(new ActiveDevice($device))->toOthers();
        }

        return response()->json('Create successfully', Response::HTTP_OK);
    }

    public function getDevice(Request $request)
    {
        $devices = device::where(function ($query) use ($request) {
            $query->where('deviceName', 'LIKE', '%' . $request->term . '%');
            $query->orwhere('deviceID', 'LIKE', '%' . $request->term . '%');
        })->paginate(20)->appends(['term' => $request->term]);

        return Inertia::render('Zoom/Device', compact('devices'));
    }

  
}
