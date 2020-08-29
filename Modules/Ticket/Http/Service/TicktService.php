<?php


namespace Modules\Ticket\Http\Service;


use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Ticket\Http\Repository\TicketRepository;

class TicktService extends ResponseService
{
    private $ticket;

    public function __construct()
    {
        $this->ticket = new TicketRepository();
    }

    public function create($data)
    {
        if (isset($data['ticket_id']))
            return $this->createTicketHistory($data);
        else
            return $this->createTicket($data);
    }

    /*add new tickect by user*/
    public function createTicket($data)
    {
        $data['user_id'] = Auth::user()->id;
        $result = $this->ticket->create($data);
        if ($result === 2) {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error,Image Not Valid"));
        }elseif ($result == true) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    public function createTicketHistory($data)
    {
        $result = $this->ticket->newHistory($data);
        if ($result === 2) {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error,Image Not Valid"));
        }else if ($result === 3) {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Ticket ID Doesn't exists"));
        }else if ($result === 4) {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Ticket Status Closed"));

        } elseif ($result == true) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    /*get all ticket related to specific user*/
    public function getAllTicketUser()
    {
        $user_id = Auth::user()->id;
        $result = $this->ticket->getAllTicketUser($user_id);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    /*get specific ticket by id*/
    public function getTicktById($id)
    {
        $result = $this->ticket->show($id);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    public function getAllTickets()
    {
        $result = $this->ticket->all();
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    public function createTicketStatus($data)
    {
        $data['admin_id'] = Auth::user()->id;
        $result = $this->ticket->saveStatus($data);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    public function getStatus()
    {
        $result = $this->ticket->getStatus();
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    public function all($request)
    {
        $result = $this->ticket->all($request);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }

    public function ticketStatusId($id)
    {
        $result = $this->ticket->ticketStatusId($id);
        if ($result) {
            return $this->responseWithSuccess($result);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
}
