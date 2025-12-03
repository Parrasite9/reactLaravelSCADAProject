<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

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
        return Inertia::render('Details', [
            'device' => $device,
        ]);
    }

    public function updateIP($id, Request $request) {
        $device = Device::findOrFail($id);

        $device->ip = $request->input('ip');
        $device->port = $request->port;
        $device->save();

        return back()->with('success', 'Device updated successfully');
    }

    public function createDevice(Request $request) { //Receives form data from react

        // Checks the IP is valid
        $validated = $request->validate([
            'ip' => ['required', 'regex:/^\d{1,2}\.\d{1,2}\.\d{1,2}\.\d{1,2}$/'],
            'port' => 'required|integer|min:1|max:65535'
        ]);

        $exists = Device::where('ip', $validated['ip'])
                            ->where('port', $validated['port'])
                            ->exists();

        if ($exists) {
            return back()->withErrors(['ip' => 'This IP + port combination already exists']);
        }

        // Saves new device in DB
        Device::create([
            'ip' => $validated['ip'],
            'port' => $validated['port'],
            'value' => 0,
        ]);

        // Sends user back with a success message
        return redirect()->back()->with('success', 'Device created!');

    }

}
