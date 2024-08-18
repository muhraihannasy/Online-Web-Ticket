<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;

use App\Models\BookingTransaction;
use App\Models\Ticket;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;


use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Customer';

    public static function getNavigationBadge(): ?string
    {
        $countBookinngTransactionIsNotPaid = BookingTransaction::where('is_paid', 0)->count();
        return $countBookinngTransactionIsNotPaid > 0 ? $countBookinngTransactionIsNotPaid : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Wizard::make([
   Wizard\Step::make('Product and Price')
                    ->schema([
                        Select::make('ticket_id')
                        ->label('ticket')
                        ->relationship('ticket', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $ticket = Ticket::find($state);

                            if(isset($ticket)) $set('price', $ticket->price ? $ticket->price : 0);

                        }),

                        TextInput::make('total_participant')
                        ->numeric()
                        ->prefix('people')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $price = $get('price');
                            $totalAmount = $state * $price;

                            $set('total_amount', $totalAmount);
                        }),

                        TextInput::make('total_amount')
                        ->required()
                        ->numeric()
                        ->prefix('Rp. ')
                        ->readOnly()
                        ->helperText('Sudah include dengan ppn 11%')
                    ])->columns(3),


                Wizard\Step::make('Customer Information')
                    ->schema([
                        TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                        TextInput::make('phone_number')
                        ->required()
                        ->maxLength(255),

                        TextInput::make('email')
                        ->required()
                        ->maxLength(255),

                        TextInput::make('booking_trx_id')
                        ->required()
                        ->maxLength(255),
                    ])->columns(3),


                Wizard\Step::make('Payment Information')
                    ->schema([
                        ToggleButtons::make('is_paid')
                        ->label('Apakah sudah membayar ?')
                        ->boolean()
                        ->grouped()
                        ->icons([
                            true => 'heroicon-o-pencil',
                            false => 'heroicon-o-clock',
                        ])
                        ->required(),

                        FileUpload::make('proof')
                        ->image()
                        ->required(),

                        DatePicker::make('started_at')
                        ->required(),

                    ]),
            ])->columnSpan('full')
            ->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ImageColumn::make('ticket.thumbnail')->circular(),
                TextColumn::make('name')
                ->searchable(),


                TextColumn::make('booking_trx_id')
                ->searchable(),

                IconColumn::make('is_paid')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->label('Terveritifikasi'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Action::make('approve')
                ->label('Approve')
                ->action(function (BookingTransaction $record) {
                    $record->is_paid = true;
                    $record->save();

                    Notification::make()
                    ->title("Ticket Approved")
                    ->body("Ticket has been approved")
                    ->success()
                    ->send();
                })
                ->requiresConfirmation()
                ->color('success')
                // ->visible(fn (BookingTransaction $record) => !$record->is_paid),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
