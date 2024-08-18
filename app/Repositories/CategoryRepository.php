<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepositoryInterface;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return Category::latest()->get();
    }
}
