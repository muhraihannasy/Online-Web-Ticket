<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Repositories\CategoryRepository;

class FrontService
{
    protected $ticketRepository;
    protected $categoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        TicketRepository $ticketRepository
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->categoryRepository = $categoryRepository;
    }


    public function frontPage()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $popularTicket = $this->ticketRepository->getPopularTicket();
        $newTickets = $this->ticketRepository->getAllNewTicket();

        return compact('categories', 'popularTicket', 'newTickets');
    }
}
