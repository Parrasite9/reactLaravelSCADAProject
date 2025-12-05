<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\Device;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class queryxml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:queryxml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ip = $this->ask('What IP are you trying to access? (DONT INCLUDE PORT)');
        $port = $this->ask('What is the Port?');

        $firstDevice = Device::query()->where('ip', '=', $ip)->where('port', '=', $port)->first();

        if (!$firstDevice) {
            $this->info('Device Not Found');
            return Command::FAILURE;
        }

        $ipAndPort = "{$ip}" . ':' . "{$port}";
        $this->info("Checking {$ipAndPort}");

        $dataRoute = "http://{$ipAndPort}/state.xml";
        $this->info($dataRoute);

        $xml = Http::get($dataRoute);

        if (!$xml) {
            $this->error("Failed to fetch XML from {$dataRoute}");
            return Command::FAILURE;
        }

        $xmlObject = simplexml_load_string($xml);

        $valueAsString = (string) $xmlObject->relay1state;

        $valueAsBool = (bool) $valueAsString;

        $newActivityLog = new ActivityLog();

        $newActivityLog->value = $valueAsBool;
        $newActivityLog->save();


        // $this->info($xml);

        return Command::SUCCESS;
    }
}
