<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LaundryCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.laundry-completed')
                    ->subject('Pesanan Laundry Anda Telah Selesai - LaundryEase')
                    ->with([
                        'transaction' => $this->transaction,
                        'customer' => $this->transaction->customer,
                        'branchStore' => $this->transaction->branchStore,
                        'service' => $this->transaction->service,
                    ]);
    }
}
