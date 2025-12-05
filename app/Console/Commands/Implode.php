<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Implode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:implode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description: This makes the app implode.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Boom! But from the inside!');
    }
}
