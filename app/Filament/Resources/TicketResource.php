<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Set;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\CreateAction;


use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions\Action;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;

use Filament\Tables\Filters\SelectFilter;

use Filament\Support\RawJs;


class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            Fieldset::make('Details')->schema([

                TextInput::make('name')
                ->required()
                ->default("helo")
                ->maxLength(255)
                ->default('Singapore Night Safari Ticket')
                ,

                Textarea::make('address')
                ->rows(4)
                ->required()
                ->maxLength(255)
                ->default("80 Mandai Lake Road, Singapore 729826")
                ,
            ])
            ->columns(2),

            Fieldset::make('Details')->schema([

                FileUpload::make('thumbnail')
                ->image()
                ->required(),

                Repeater::make('phhotos')
                ->relationship('photos')
                ->schema([
                    FileUpload::make('photo')
                    ->image()
                    ->required(),
                ])

            ])
            ->columns(2),

            Fieldset::make('Additional')->schema([

                Grid::make([
                'default' => 1,
                'sm' => 2,
                'lg' => 3,
                'xl' => 4,
                ])
                ->schema([
                    TimePicker::make('open_at_time')
                    ->required(),

                    TimePicker::make('closed_at_time')
                    ->required(),

                    TextInput::make('price')
                    ->integer()
                    ->prefix('Rp. '),

                    Toggle::make('is_popular')
                    ->inline(false)
                    ->default(true),
                ]),

                Grid::make([
                'default' => 1,
                'sm' => 2,
                'lg' => 3,
                ])
                ->schema([
                    Select::make('category_id')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),

                    Select::make('seller_id')
                    ->relationship('seller', 'name')
                    ->preload()
                    ->searchable(),

                    TextInput::make('path_video')
                    ->required()
                    ->maxLength(255)
                    ->default("iuMQMYgPMhhh7TZn"),
                ]),

            Grid::make([
                'default' => 1,
                ])
                ->schema([
                RichEditor::make('about')
                ->required()
                ->maxLength(255)
                ->default("Experience the thrill of the night at the Singapore Night Safari, with guided tours and close-up encounters with nocturnal animals.")
               ,
                ]),

            ])
            ->columns(2),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('price')->money(),
                ImageColumn::make('thumbnail')->circular(),
                TextColumn::make('is_popular'),
                ToggleColumn::make('is_popular')
            ])
            ->filters([
                SelectFilter::make('category_id')
                ->label('category')
                ->relationship('category', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }

}
