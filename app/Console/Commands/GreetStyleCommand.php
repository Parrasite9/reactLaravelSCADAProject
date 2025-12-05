<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GreetStyleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:greet-style-command {name} {--shout}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description: Greets user with optional shout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $shout = $this->option('shout');

        $message = "Hello, {$name}!";

        if ($shout) {
            $message = strtoupper($message);
        }

        $this->info($message);

        return Command::SUCCESS;
    }
}
