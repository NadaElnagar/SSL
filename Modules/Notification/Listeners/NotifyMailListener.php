<?php

namespace Modules\Notification\Listeners;

use Modules\Notification\Emails\SendEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Events\NotifyMail;
use Mail;
class NotifyMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param NotifyMail $event
     * @return void
     */
    public function handle(NotifyMail $event)
    {
        $emails =explode(',', $event->to);

        foreach ($emails as  $to){

             Mail::to($to)
                ->send(new SendEmail($event->website_name,$event->title,$event->body,$event->subject));
        }
    }
}
