<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeForAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:for-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('config:cache');
        $this->call('route:cache');
        $this->info('API optimized: Configuration and Routes cached.');
    }
}
