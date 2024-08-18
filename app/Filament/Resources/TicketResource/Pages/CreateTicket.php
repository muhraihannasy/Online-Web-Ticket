<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables\Actions\CreateAction;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

}