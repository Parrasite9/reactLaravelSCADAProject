<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeviceController extends Controller
{
    public function togglePower($id)
    {
        // Find the device by IP
        $device = Device::findOrFail($id);

        $value = $device->value;
        $device->save();

        $value = $device->value == 1 ? 0 : 1;
        $device->value = $value;
        $device->save();

        $ip = $device->ip;

        $NewEntry = new ActivityLog();
        $NewEntry->value = $value;
        $NewEntry->save();

        if ($value == 1) {
            $response = Http::get("http://{$ip}/state.xml?relay1=1");
            return 'Power is: On';
        } else {
            $response = Http::get("http://{$ip}/state.xml?relay1=0");
            return 'Power is: Off';
        }
    }

    public function viewDetails($id) {
        $device = Device::findOrFail($id);
        return view('details', ['device' => $device]);
    }

    public function updateIP($id, Request $request) {
        $device = Device::findOrFail($id);

        $device->ip = $request->input('ip');
        $device->save();

        return back()->with('success', 'Device updated successfully');
    }
}
