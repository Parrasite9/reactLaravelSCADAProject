<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dancing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dancing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description: Hitting the dougie.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Hit the dougie');
    }
}
