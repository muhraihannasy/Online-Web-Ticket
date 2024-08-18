<?php

namespace App\Repositories\Contracts;

interface BookingRepositoryInterface
{
    public function createBooking(array $data);
    public function findByTrxIdAndPhone(string $trxId, string $phone);
}
