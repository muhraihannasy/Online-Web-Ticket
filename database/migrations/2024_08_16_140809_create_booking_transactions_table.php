<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('phone_number');
            $table->string('email');

            $table->unsignedBigInteger('total_amount');
            $table->unsignedInteger('total_participant');
            $table->boolean('is_paid');

            $table->date('started_at');
            $table->string('proof');

            $table->string('booking_trx_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_transactions');
    }
};
