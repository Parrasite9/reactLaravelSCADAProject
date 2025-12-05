<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class hello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description: Gives a greeting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Hello from this command line');
        return Command::SUCCESS;
    }
}
