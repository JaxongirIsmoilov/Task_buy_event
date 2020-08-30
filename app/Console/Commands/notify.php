<?php

namespace App\Console\Commands;

use App\Client;
use App\Notifications\InvoicePaid;
use App\Shopping;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class notify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification sent successfully!!!';

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
        try {
            $client = Client::findOrFail($this->ask('Please enter client id number'));
            $shopping = Shopping::findOrFail($this->ask('Please enter product id number'));
            $defaultIndex = 'email';
            $channel = $this->choice(
              'Choose the channel',
                ['mail', 'nexmo', 'database'],
                $defaultIndex,
                $maxAttempts = null,
                $allowMultipleSections = false
            );
            $client->notify(new InvoicePaid($channel, $shopping));
            echo "Notification sent successfully!" . "\n";

        } catch (\Exception $e){
            dump('Notification didn`t send. Error!' . $e->getMessage());
            Log::error($e->getMessage());
        }
    }
}
