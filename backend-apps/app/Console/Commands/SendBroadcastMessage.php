<?php

namespace App\Console\Commands;

use App\Jobs\BroadcastMessageJob;
use Illuminate\Console\Command;

class SendBroadcastMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:send {message : The message to broadcast to all users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a broadcast message to all users via email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = $this->argument('message');

        if (empty($message)) {
            $this->error('Message cannot be empty!');
            return 1;
        }

        $this->info('Sending broadcast message to all users...');
        $this->line("Message: {$message}");

        try {
            // Dispatch the job
            BroadcastMessageJob::dispatch($message);
            
            $this->info('✅ Broadcast message has been queued successfully!');
            $this->line('The message will be sent to all users via email.');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Failed to queue broadcast message: ' . $e->getMessage());
            return 1;
        }
    }
}
