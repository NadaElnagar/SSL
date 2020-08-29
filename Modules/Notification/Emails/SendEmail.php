<?php

namespace Modules\Notification\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $website_name,$title,$body,$subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($website_name,$title,$body,$subject)
    {
        $this->website_name     =  $website_name;
        $this->title            = $title;
        $this->body             = $body;
        $this->subject          = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('notification::emails/email')
            ->subject( $this->subject );
    }
}
