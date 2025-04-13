<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateProfilePDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public $tries = 3;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pdf = PDF::loadView('profile.pdf', ['user' => $this->user]);

        // Save the PDF
        $path = storage_path("app/public/profiles/{$this->user->id}.pdf");
        $pdf->save($path);

        // Update user record with PDF path
        $this->user->update(['profile_pdf_path' => "profiles/{$this->user->id}.pdf"]);
    }
}
