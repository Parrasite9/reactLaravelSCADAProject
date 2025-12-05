<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class secureNote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:secure-note';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description: Makes hidden input';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $secret = $this->secret('Enter a secret (input hidden):');
        $this->info("You typed something... but I cant show it!");

        $reveal = $this->ask("Do you want me to reveal your secret? Y/N");

        if ($reveal == "y" || $reveal == "Y") {
            $this->info("Your secret was: You are gay!");
            return Command::SUCCESS;
        }

        $this->info('Your secret is safe with me!');

        return Command::SUCCESS;
    }
}
