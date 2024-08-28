<?php

namespace App\Repositories\Contracts;

interface SellerRepositoryInterface
{
    public function getAllSellers($limit = 5);
}
