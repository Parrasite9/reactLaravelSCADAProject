<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class askName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ask-name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description: Asks user for name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('What is your name?');

        $this->info("Nice to meet you {$name}!");

        return Command::SUCCESS;
    }
}
