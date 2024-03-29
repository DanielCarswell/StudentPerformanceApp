<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\Tables\Circumstance_link;

class Circumstances extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $information;
    public $cirname;
    public $links;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $cirname, String $information, $links)
    {
        $this->user = $user;
        $this->cirname = $cirname;
        $this->links = $links;
        $this->information = $information;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.circumstance');
    }
}
