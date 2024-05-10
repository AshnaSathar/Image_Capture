<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
     /**
     * Check if the device ID exists in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkDevice(Request $request)
    {
        $deviceId = $request->input('device_id');

        // Check if the device ID exists in the database
        $device = Device::where('device_id', $deviceId)->first();

        if ($device) {
            // Device ID exists
            return response()->json(['user_id' => $device->user_id]);
        } else {
            // Device ID does not exist
            return response()->json(['user_id' => null]);
        }
    }
    
    /**
     * Store a new device ID and associate it with the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'device_id' => 'required|unique:devices',
        ]);

        // Create a new device record
        $device = new Device();
        $device->device_id = $request->device_id;
        $device->user_id = Auth::id(); // Associate the device with the authenticated user
        $device->save();

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'Device ID stored successfully'], 201);
    }
}
