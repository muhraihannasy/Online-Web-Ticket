<?php

namespace App\Repositories;


use App\Repositories\Contracts\TicketRepositoryInterface;

use App\Models\Ticket;

class TicketRepository implements TicketRepositoryInterface
{
    public function getPopularTicket($limit = 5)
    {
        return Ticket::where('is_popular', true)->get();
    }

    public function getAllNewTicket()
    {
        return Ticket::where('is_popular', false)->get();
    }

    public function findTicket(string $id)
    {
        return Ticket::find($id);
    }

    public function getPrice(string $id)
    {
        $ticket = $this->findTicket($id);
        return $ticket->price ? $ticket->price : 0;
    }
}
