<?php

namespace App\Repositories;

use App\Models\BookingTransaction;

class BookingRepository implements BookingRepositoryInterface
{
    public function createBooking(array $data)
    {
        return BookingTransaction::create($data);
    }

    public function findByTrxIdAndPhone(string $trxId, string $phone)
    {
        return BookingTransaction::where('booking_trx_id', $trxId, 'phone_number', $phone)->first();
    }


}
