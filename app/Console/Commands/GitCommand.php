<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symphony\Compomemt\Process\Process;

class GitCommand extends Command
{
    protected $signature = 'git:push [message]';

    protected $description = 'Git Command push to repo';

    public function handle()
    {
        $message = $this->argument('message');

        (new Process(['git', 'add', '.']))->run();

        (new Process(['git', 'commit', '-m', $message]))->run();

        (new Process(['git', 'push']))->run();
        $this->info('Repository uodated');
    }
}
