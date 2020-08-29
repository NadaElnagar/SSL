<?php

namespace Modules\Notification\Events;

use Illuminate\Queue\SerializesModels;

class NotifyMail
{
    use SerializesModels;
    public $website_name,$title,$body,$to,$subject;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->website_name    =  $data['website_name'];
        $this->title           = $data['title'];
        $this->body            = $data['body'];
        $this->to              = $data['to'];
        $this->subject         = $data['subject'];
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
