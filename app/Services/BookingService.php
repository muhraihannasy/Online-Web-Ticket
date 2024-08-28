<?php

namespace App\Services;

use App\Models\BookingTransaction;
use Illuminate\Support\Facades\DB;
use App\Repositories\TicketRepository;
use App\Repositories\BookingRepository;

class BookingService
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

    public function payment()
    {
        $booking = session('booking');
        $ticket = $this->ticketRepository->findTicket($booking['ticket_id']);

        return compact('booking', 'ticket');
    }

    public function paymentStore(array $validate)
    {
        $booking = session('booking');
        $bookingTransactionId = null;

        DB::transaction(function() use ($validate, &$bookingTransactionId, $booking) {
            if (isset($validate['proof'])) {
                $proofPath = $validate['proof']->store('proofs', 'public');
                $validate['proof'] = $proofPath;
            }

            $validate['name'] = $booking['name'];
            $validate['ticket_id'] = $booking['ticket_id'];
            $validate['email'] = $booking['email'];
            $validate['phone_number'] = $booking['phone_number'];
            $validate['started_at'] = $booking['started_at'];
            $validate['total_participant'] = $booking['total_participant'];
            $validate['subtotal'] = $booking['subtotal'];
            $validate['total_ppn'] = $booking['total_ppn'];
            $validate['total_amount'] = $booking['total_amount'];
            $validate['is_paid'] = false;
            $validate['booking_trx_id'] = BookingTransaction::generateUniqueTrxId();

            $newBooking = $this->bookingRepository->createBooking($validate);
            $bookingTransactionId = $newBooking->id;
        });

        return $bookingTransactionId;
    }


}
