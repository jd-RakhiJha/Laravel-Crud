<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class AddToNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $email;
    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.mailchimp.key'),
        ])->post('https://usX.api.mailchimp.com/3.0/lists/' . config('services.mailchimp.list_id') . '/members', [
            'email_address' => $this->email,
            'status' => 'subscribed'
        ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to add to newsletter: ' . $response->body());
        }
    }
}
