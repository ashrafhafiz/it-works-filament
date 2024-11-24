<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Sector;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Locations', Location::count()),
            Stat::make('Total Sectors', Sector::count()),
            Stat::make('Total Departments', Department::count()),
            Stat::make('Total Employees', Employee::count()),
            Stat::make('Total Active Employees', Employee::query()->active()->count()),
            Stat::make('Total Terminated Employees', Employee::query()->terminated()->count()),
        ];
    }
}
