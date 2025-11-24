<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $subject = 'Thư mời phỏng vấn - ' . $this->data['job_title'];

        // Choose template based on type
        $template = 'emails.interview-invitation-' . $this->data['template'];

        return $this->subject($subject)
            ->view($template)
            ->with($this->data);
    }
}
