<?php


namespace Modules\Notification\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\Notification\Http\Requests\mailRequest;
use Modules\Notification\Http\Service\NotificationService;

class NotificationApiController  extends Controller
{
    private $notification;
    public function __construct()
    {
        $this->notification = new NotificationService();
    }
    public function sendMail(mailRequest $request)
    {
        return $this->notification->sendMail($request);
    }
}
