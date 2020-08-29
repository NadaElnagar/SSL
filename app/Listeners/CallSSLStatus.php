<?php


namespace App\Listeners;


use App\Events\OrderItem;
use App\Http\Services\SingletonService;
 use Modules\SSL\Http\Services\SSLServices;

class CallSSLStatus
{

    public function __construct()
    {
        $this->ssl = SingletonService::serviceInstance(SSLServices::class);
    }

    /**
     * Handle the event.
     *
     * @param  OrderItem  $event
     * @return void
     */
    public function handle(OrderItem $event)
    {
       $this->ssl->order_status($event->item);
    }
}
