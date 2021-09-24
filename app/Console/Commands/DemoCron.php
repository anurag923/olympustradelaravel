<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Http;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //\Log::info("Cron is working fine!");
        // $response = Http::get('https://api.polygon.io/v1/open-close/crypto/BTC/USD/2021-09-23?adjusted=true&apiKey=6sEFcNe2upitHW5lt9dp7EfkIuxoR58k');
        // $val = $response->json();
        // $close = $val['close'];
        // \Log::info($close);
    }
}
