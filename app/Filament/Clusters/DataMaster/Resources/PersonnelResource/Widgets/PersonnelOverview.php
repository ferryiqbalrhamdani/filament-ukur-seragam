<?php

namespace App\Filament\Clusters\DataMaster\Resources\PersonnelResource\Widgets;

use App\Filament\Clusters\DataMaster\Resources\PersonnelResource\Pages\ListPersonnels;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PersonnelOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListPersonnels::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Personel', number_format($this->getPageTableQuery()->count(), 0, ',', '.')),
            Stat::make('Personel Pria', number_format($this->getPageTableQuery()->where('personel_kelamin', 'L')->count(), 0, ',', '.')),
            Stat::make('Personel Wanita', number_format($this->getPageTableQuery()->whereIn('personel_kelamin', ['P', 'PJ'])->count(), 0, ',', '.')),
        ];
    }
}
