<?php

namespace App\Repositories;

use App\Models\Seller;

use App\Repositories\Contracts\SellerRepositoryInterface;

class SellerRepository implements SellerRepositoryInterface
{
    public function getAllSellers($limit = 5)
    {
        return Seller::all()->take($limit);
    }
}
