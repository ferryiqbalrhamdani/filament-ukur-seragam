<?php

namespace App\Filament\Resources\UkurSeragamResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\UkurSeragamResource\Pages\ListUkurSeragams;

class StatsUkurSeragamOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListUkurSeragams::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Data', number_format($this->getPageTableQuery()->count(), 0, ',', '.')),
        ];
    }
}
