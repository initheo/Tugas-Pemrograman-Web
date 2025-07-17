<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\BroadcastMessageMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BroadcastMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Get all users from database
            $users = User::whereNotNull('email')->get();
            
            Log::info("Broadcasting message to {$users->count()} users");
            
            // Send email to each user
            foreach ($users as $user) {
                try {
                    Mail::to($user->email)->send(new BroadcastMessageMail($this->message, $user));
                    Log::info("Message sent successfully to: {$user->email}");
                } catch (\Exception $e) {
                    Log::error("Failed to send message to {$user->email}: " . $e->getMessage());
                }
            } 
             
            Log::info("Broadcast message job completed successfully");
            
        } catch (\Exception $e) {
            Log::error("Broadcast message job failed: " . $e->getMessage());
            throw $e;
        }
    }
}
