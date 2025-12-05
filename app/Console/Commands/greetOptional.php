<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class greetOptional extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:greet-optional {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description: Gives greeting, but name is optional';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument("name");

        if (!$name) {
            $name = 'stranger';
        }

        $this->info("Hello, {$name}");

        return Command::SUCCESS;
    }
}
