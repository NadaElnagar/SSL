<?php


namespace Modules\Ticket\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Ticket\Http\Requests\AdminTicketRequest;
use Modules\Ticket\Http\Requests\TicketStatus;
use Modules\Ticket\Http\Service\TicktService;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    private $ticket;
    public function __construct()
    {
        $this->ticket = new TicktService();
    }
    /*Reply user in ticket*/
    public function createTicket(AdminTicketRequest $request)
    {
        return $this->ticket->createTicketHistory($request);
    }
    public function replyTicket(AdminTicketRequest $request)
    {
        $request->admin_id = Auth::user()->id;
        return $this->ticket->createTicketHistory($request);
    }
    /*add new tickect by user*/
    public function createTicketStatus(TicketStatus $request)
    {
        return $this->ticket->createTicketStatus($request);
    }
    /*get Status from table (0=new, 1=appending , 2= closed)*/
    public function getStatus()
    {
        return $this->ticket->getStatus();
    }
    public function getAllTickets(Request $request)
    {
        return $this->ticket->all($request);
    }
    public function ticketStatusId($id)
    {
        return $this->ticket->ticketStatusId($id);
    }
}
