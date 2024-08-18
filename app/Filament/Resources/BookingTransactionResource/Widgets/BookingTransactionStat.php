<?php

namespace App\Filament\Resources\BookingTransactionResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\BookingTransaction;

class BookingTransactionStat extends BaseWidget
{
    protected function getStats(): array
    {

        $totalTransaction = BookingTransaction::count();
        $approvedTransactions = BookingTransaction::where('is_paid', true)->count();
        $totalRevenue = BookingTransaction::where('is_paid', true)->sum('total_amount');


        return [
             Stat::make('Total Transaction', $totalTransaction)
            ->description('All transactions')
            ->descriptionIcon('heroicon-o-currency-dollar'),

            Stat::make('Approved Transaction', $approvedTransactions)
                ->description('Approved transactions')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success'),

            Stat::make('Total Revenue', "IDR . " . number_format($totalRevenue))
                ->description('Revenue from approved transactions')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
