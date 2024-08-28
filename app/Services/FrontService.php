<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SellerRepository;

class FrontService
{
    protected $ticketRepository;
    protected $categoryRepository;
    protected $sellerRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        TicketRepository $ticketRepository,
        SellerRepository $sellerRepository

    ) {
        $this->ticketRepository = $ticketRepository;
        $this->sellerRepository = $sellerRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function frontPage()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $sellers = $this->sellerRepository->getAllSellers();
        $popularTickets = $this->ticketRepository->getPopularTicket();
        $newTickets = $this->ticketRepository->getAllNewTicket();

        return compact('categories', 'sellers', 'popularTickets', 'newTickets');
    }
}
