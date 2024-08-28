<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'name',
        'phone_number',
        'email',
        'total_amount',
        'total_participant',
        'is_paid',
        'started_at',
        'proof',
        'booking_trx_id',
    ];

    protected $casts = [
        'started_at' => 'date',
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = "JRT";

        do {
            $randomString = $prefix . mt_rand(1000, 9999);

        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
