<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationRejection extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $subject = 'Thông báo kết quả ứng tuyển - ' . $this->data['job_title'];

        return $this->subject($subject)
            ->view('emails.application-rejection')
            ->with($this->data);
    }
}
