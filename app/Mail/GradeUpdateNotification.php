<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class GradeUpdateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $score;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $score)
    {
        $this->user = $user;
        $this->score = $score;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.grades.update');
    }
}
