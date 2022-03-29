<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class LowGradeLecturerNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $message;
    public $score;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $message, String $score)
    {
        $this->user = $user;
        $this->message = $message;
        $this->score = $score;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.grades.lecturer_warning');
    }
}
