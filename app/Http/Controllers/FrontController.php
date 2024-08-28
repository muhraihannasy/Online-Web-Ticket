<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Ticket;

use App\Services\FrontService;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct(
        FrontService $frontService,
    ) {
        $this->frontService = $frontService;
    }

    public function index()
    {
        // dd($this->frontService->frontPage());
        return view('front.index', $this->frontService->frontPage());
    }

    public function category(Category $category)
    {
        return view('front.category', compact('category'));
    }

    public function details(Ticket $ticket)
    {
        return view('front.details', compact('ticket'));
    }

}
