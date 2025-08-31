<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:hotel {--port=8000} {--host=0.0.0.0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Laravel development server with proper host binding for hotel management system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');

        $this->info("Starting Laravel development server...");
        $this->info("Server will be available at:");
        $this->info("- http://localhost:{$port}");
        $this->info("- http://127.0.0.1:{$port}");
        $this->info("- http://{$host}:{$port}");
        $this->info("");
        $this->info("Press Ctrl+C to stop the server");
        $this->info("");

        // Create the process
        $process = new Process([
            'php', 'artisan', 'serve',
            '--host=' . $host,
            '--port=' . $port
        ]);

        $process->setTty(true);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        return Command::SUCCESS;
    }
}
