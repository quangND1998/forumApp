<?php

namespace App\Http\Controllers;

use App\Events\DeviceSessionEvent;
use App\Models\device;
use App\Models\User;
use App\Models\Zoom;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ZoomController extends Controller
{
    public function store()
    {
        $zoom = Zoom::create([
            'code' => Str::random(4),
            'user_id' => Auth::user()->id
        ]);
        return back()->with('success', 'Create successfully');
    }

    public function joinZoom(Request  $request)
    {

        $zoom = Zoom::with('devices')->where('code', $request->code)->first();
        $device = device::where('deviceID', $request->deviceID)->first();

        $check = Zoom::whereHas('devices', function ($query) use ($device) {
            $query->where('devices.id', $device->id);
        })->where('code', $request->code)->first();

        if ($zoom == null) {
            return response()->json('Not Found Zoom', Response::HTTP_BAD_REQUEST);
        }

        if ($device == null) {
        } else {
            $device->update([
                'deviceID' => $request->deviceID,
                // 'state' => $request->state,
                'battery' => $request->battery
            ]);
            if ($check == null) {
                $zoom->devices()->attach(
                    $device,
                    [
                        'state' => $request->state
                    ]
                );
            } else {
                $zoom->devices()->updateExistingPivot($device->id, ['state' => $request->state]);
            }
            $newdevice = $zoom->devices()->where('zoom_id', $zoom->id)
                ->where('device_id', $device->id)->first();


            broadcast(new DeviceSessionEvent($newdevice, $zoom))->toOthers();
        }

        return response()->json('Create successfully', Response::HTTP_OK);
    }

    public function getZoom()
    {
        $user = User::with('zooms.devices')->findOrFail(Auth::user()->id);
        return Inertia::render('Zoom/Index', compact('user'));
    }

    public function getZoomCode(Request $request, $code)
    {

        $zoom = Zoom::where('code', $code)->first();
        if ($zoom == null) {
            return back()->with('warning', 'Session not Found');
        }

        $devices = $zoom->devices()->where(function ($query) use ($request) {
            $query->where('deviceName', 'LIKE', '%' . $request->term . '%');
            $query->orwhere('deviceID', 'LIKE', '%' . $request->term . '%');
        })->paginate(20)->appends(['term' => $request->term]);

        return Inertia::render('Zoom/ZoomDevice', compact('devices', 'zoom'));
    }

    public function deleteZoom($id)
    {
        $zoom = Zoom::findOrFail($id);
        $zoom->delete();
        return back()->with('success', 'Delete successfully');
    }

    public function deleteAll(Request $request)
    {

        $ids = $request->ids;
        if ($ids == null) {
            return back()->with('warning', "You must choose in checkbox !!!.");
        }
        $zooms = Zoom::whereIn('id',  $ids)->get();
        foreach ($zooms as $zoom) {
            $zoom->delete();
        }
        return back()->with('success', "Delete changed successfully.");
    }
}
