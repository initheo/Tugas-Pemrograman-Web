<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaundryCompletedMail;
use App\Models\Transaction;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-laundry-completed {transaction_id} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sending laundry completed email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $transactionId = $this->argument('transaction_id');
        $email = $this->argument('email');

        try {
            // Find transaction with relations
            $transaction = Transaction::with(['customer', 'branchStore', 'service'])->find($transactionId);
            
            if (!$transaction) {
                $this->error("Transaction with ID {$transactionId} not found!");
                return 1;
            }

            $this->info("Sending test email to: {$email}");
            $this->info("Transaction ID: {$transaction->id}");
            $this->info("Customer: " . ($transaction->customer ? $transaction->customer->name : 'N/A'));

            // Send email
            Mail::to($email)->send(new LaundryCompletedMail($transaction));

            $this->info("✅ Email sent successfully!");
            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            return 1;
        }
    }
}
