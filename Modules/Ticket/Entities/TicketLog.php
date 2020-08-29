<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Model;

class TicketLog extends Model
{
    protected $table ="ticket_logs";
    public function getStatus()
    {
        return $this->hasOne(statusTicket::class,'id','status');
    }
    public function getTicketDetails()
    {
        return $this->belongsTo(Ticket::class,'ticket_id','id');
    }
}
