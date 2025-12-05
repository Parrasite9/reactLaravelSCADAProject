<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class greet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:greet {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description: This greets the user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument("name");
        $this->info("Hello {$name}");
        return Command::SUCCESS;
    }
}
