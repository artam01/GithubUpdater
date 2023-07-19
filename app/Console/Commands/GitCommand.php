<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GitCommand extends Command
{
    protected $signature = 'git:push {message?}';

    protected $description = 'Push changes to the remote git repository';

    public function handle()
    {
        $message = $this->argument('message') ?: 'Update from git:push command';

        $this->info('Running git add .');
        $this->executeProcess('git add .');

        $this->info('Running git commit');
        $this->executeProcess("git commit -m \"$message\"");

        $this->info('Running git push');
        $this->executeProcess('git push');

        $this->info('Git push successful!');
    }

    protected function executeProcess($command)
    {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(null);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
