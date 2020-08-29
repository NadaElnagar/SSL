<?php


namespace Modules\Ticket\Http\Repository;

use Modules\Ticket\Entities\statusTicket;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketAttachment;
use Modules\Ticket\Entities\TicketHistory;
use Modules\Ticket\Entities\TicketLog;

class TicketRepository
{
    /*all tickect from user*/
    public function all($request)
    {
        $limit = $request['limit'];
        $offset = $request['offset'] * $limit;
        $ticket = ((new Ticket())->newQuery())->with('getStatus');
        $result['count'] = $ticket->count();
        $result['data'] = $ticket->get();
        return $result;
    }

    /*add new ticket by user*/
    public function create($data)
    {
        $ticket = new Ticket();
        $ticket->users_id = $data->user_id;
        $ticket->status = 1;
        if ($data['description']) $ticket->description = $data['description'];
        if ($ticket->save()) {
            if ($data['images']) {
                $result = array('ticket_id' => $ticket->id, 'images' => $data['images']);
                if ($this->ticketAttachment($result)) {
                    return true;
                } else {
                   /*Ticket Save But image not valid */
                    return 2;
                }
            }
            return true;
        } else {
            $ticket->delete();
            return false;
        }
    }

    public function newHistory($data)
    {
       $ticket =  Ticket::find($data['ticket_id']);
        if ($ticket) {
            if($ticket->status == 3) return 4;
            $ticket_history = new TicketHistory();
            if ($data->admin_id) $ticket_history->admin_id = $data->admin_id;else $ticket_history->admin_id =0;
            if ($data['description']) $ticket_history->description = $data['description'];

            $ticket_history->ticket_id = $data['ticket_id'];
            if ($ticket_history->save()) {
                if ($data['images']) {
                    $result = array('$ticket_history_id' => $ticket_history->id, 'images' => $data['images']);
                    if ($this->ticketAttachment($result)) {
                        return true;
                    } else {
                        /*Ticket Save But image not valid */
                        return 2;
                    }
                }
                return true;
            } else {
                $ticket_history->delete();
                return false;
            }
        } else {
            /*Ticket ID Doesn't exists*/
            return 3 ;
        }
    }

    private function ticketAttachment($data)
    {
        if ($data['images']) {
            $images = explode(',', $data['images']);
            foreach ($images as $key => $image) {
                if ($image_name = upload_image_base64('ticket', $image)) {
                    $ticket_attachment = new TicketAttachment();
                    if (isset($data['ticket_id']))
                        $ticket_attachment->ticket_id = $data['ticket_id'];
                    if (isset($data['ticket_history_id']))
                        $ticket_attachment->ticket_history_id = $data['ticket_history_id'];
                    $ticket_attachment->attach = $image_name;
                    if ($ticket_attachment->save()) {
                        $result[] = true;
                    } else {
                        $result[] = false;
                    }
                }else{
                    return false;
                }
            }
            return $result;
        } else {
            return true;
        }
    }

    /*get all user ticket*/
    public function getAllTicketUser($user_id)
    {
        return Ticket::where('users_id', $user_id)->with('getStatus')->get();
    }

    /**git ticket by id*/
    public function show($id)
    {
        return Ticket::with('ticketHistory')->find($id);
    }

    public function saveStatus($data)
    {
        $ticket_log = new TicketLog();
        $ticket_log->admin_id = $data['admin_id'];
        $ticket_log->ticket_id = $data['ticket_id'];
        $ticket_log->description = $data['description'];
        $ticket_log->status = $data['status'];
        if ($ticket_log->save()) {
            if ($data['status'] == 3 || $data['status'] == 2)
                Ticket::where('id', $data['ticket_id'])->update(['status' => $data['status']]);

            return true;
        } else return false;
    }

    public function getStatus()
    {
        return statusTicket::get();
    }

    public function ticketStatusId($id)
    {
        return TicketLog::with(['getStatus' => function ($q) {
            return $q->select('id', 'status');
        }])->with('getTicketDetails')->where('ticket_id', $id)->get();
    }
}
