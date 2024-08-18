<?php

namespace App\Repositories\Contracts;

interface TicketRepositoryInterface
{
    public function getPopularTicket($limit = 5);
    public function getAllNewTicket();
    public function findTicket(string $id);
    public function getPrice(string $id);
}
