<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Ticket\Http\Requests\TicketRequest;
use Modules\Ticket\Http\Service\TicktService;

class TicketControllerApi extends Controller
{
    private $ticket;
    public function __construct()
    {
        $this->ticket = new TicktService();
    }
    /*add new tickect by user*/
    public function createTicket(TicketRequest $request)
    {
        $request->user_id = Auth::user()->id;
        return $this->ticket->create($request);
    }
    /*get specific ticket by id*/
    public function getTicktById($id)
    {
        return $this->ticket->getTicktById($id);
    }
    /*get all ticket related to specific user*/
    public function getAllTicketUser()
    {
        return $this->ticket->getAllTicketUser();
    }


}
