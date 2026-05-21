<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Stats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [

            // AQUÍ VAN TUS STATS:
            Stat::make('Total Productos', Product::count())
                ->description('Pedidos totales registrados')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),

            /*[
            // AQUÍ VAN TUS STATS:
            Stat::make('Total Ventas', Order::count())
                ->description('Pedidos totales registrados')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),

            Stat::make('Ingresos', '$' . number_format(Order::where('status', 'pagado')->sum('total'), 2))
                ->description('Dinero total recaudado')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary'),
            ]; */
        ];
    }
}
