<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function checkBooking()
    {
        return view('front.checkBooking');
    }


    public function checkBookingDetails()
    {
        return view('front.checkBookingDetails');
    }


    public function payment()
    {
        return view('front.payment');
    }


    public function paymentStore()
    {
        return view('front.paymentStore');
    }


    public function booking($ticket)
    {
        return view('front.booking');
    }


    public function bookingStore($ticket)
    {
        return view('front.bookingStore');
    }


    public function bookingFinished($bookingTransaction)
    {
        return view('front.bookingFinished');
    }
}
