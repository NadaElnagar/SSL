<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $table = "ticket_attachment";
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function get_status()
    {
        return $this->belongsTo(statusTicket::class,'id','status');
    }
    public function getAttachAttribute()
    {
        return  asset('public/storage/ticket/'.$this->attributes['attach']);
    }
}
