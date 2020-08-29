<?php

namespace Modules\Ticket\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticket\Entities\statusTicket;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketAttachment;
use Modules\Ticket\Entities\TicketHistory;
use Modules\Ticket\Entities\TicketLog;

class TicketDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Ticket::truncate();
        TicketAttachment::truncate();
        TicketHistory::truncate();
        TicketLog::truncate();
        statusTicket::updateOrCreate(['status' => 'new']);
        statusTicket::updateOrCreate(['status' => 'pending']);
        statusTicket::updateOrCreate(['status' => 'closed']);
        // $this->call("OthersTableSeeder");
    }
}
