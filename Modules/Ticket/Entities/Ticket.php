<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;

class Ticket extends Model
{
    protected $table = "ticket";
    protected $appends = array('status_name','related_attachment','user');
    public function ticketHistory()
    {
       return $this->hasMany(TicketHistory::class);
    }
    public function ticketAttachment()
    {
       return $this->hasMany(TicketAttachment::class);
    }
    public function getRelatedAttachmentAttribute()
    {
        return TicketAttachment::where('ticket_id',$this->id)->select('attach')->get();
    }
    public function getStatus()
    {
        return $this->hasOne(statusTicket::class,'id','status');
    }
    public function getUserAttribute()
    {
        return User::find($this->users_id);
    }
    public function getStatusNameAttribute()
    {
        $status =statusTicket::where('id',$this->status)->select('status')->first();
      return  $status->status;
    }
}
