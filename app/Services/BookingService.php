<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use App\Repositories\TicketRepository;

class FrontService
{
    protected $bookingRepository;
    protected $ticketRepository;

    public function __construct(
        BookingRepository $bookingRepository,
        TicketRepository $ticketRepository
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->bookingRepository = $bookingRepository;
    }


    public function calculateTotals($ticketId, $totalParticipants)
    {
        $ppn = 0.11;
        $price = $this->ticketRepository->getPrice($ticketId);

        $subtotal = $price * $totalParticipants;
        $tax = $subtotal * $ppn;

        return [
            'subtotal' => $subtotal,
            'total_ppn' => $tax,
            'total_amount' => $subtotal + $tax
        ];
    }

    public function storeBookingInSession($ticket, $validatedData, $totals)
    {
        session()->put('booking', [
            'ticket_id' => $ticket->id,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'started_at' => $validatedData['started_at'],
            'total_participant' => $validatedData['total_participant'],
            'subtotal' => $totals['subtotal'],
            'total_ppn' => $totals['total_ppn'],
            'total_amount' => $totals['total_amount'],
        ]);
    }
}
