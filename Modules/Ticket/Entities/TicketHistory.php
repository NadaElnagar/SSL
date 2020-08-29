<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;
class TicketHistory extends Model
{
    protected $table = "ticket_history";
    protected $appends = array('related_attachment');
    public function ticket()
    {
        $this->belongsTo(Ticket::class);
    }
    public function getRelatedAttachmentAttribute()
    {
        return TicketAttachment::where('ticket_history_id',$this->id)->select('attach')->get();
    }
    public function getStatus()
    {
        return $this->hasOne(statusTicket::class,'id','status');
    }
}
