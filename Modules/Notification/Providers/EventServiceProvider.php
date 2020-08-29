<?php

namespace Modules\Notification\Providers;

 use Modules\Notification\Events\NotifyMail;
use Modules\Notification\Listeners\NotifyMailListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
class EventServiceProvider extends ServiceProvider
{


    protected $listen = [
        NotifyMail::class => [NotifyMailListener::class,],
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
