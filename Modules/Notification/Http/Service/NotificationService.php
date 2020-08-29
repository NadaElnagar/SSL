<?php


namespace Modules\Notification\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Support\Facades\Mail;
use Modules\Notification\Emails\SendEmail;
use Modules\Notification\Events\NotifyMail;
use Modules\Notification\Http\Repository\NotificationRepository;

class NotificationService extends ResponseService
{

    public function sendMail($data)
    {
       return  event(new NotifyMail($data));
    }
}
