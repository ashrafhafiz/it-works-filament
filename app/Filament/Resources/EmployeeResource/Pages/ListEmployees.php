<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Support\Enums\IconPosition;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource;
use App\Models\Employee;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All employees')
                ->badge(Employee::all()->count())
                ->badgeColor('primary'),
            'active' => Tab::make('Active employees')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'active'))
                ->icon('heroicon-o-shield-check')
                ->iconPosition(IconPosition::Before)
                ->badge(Employee::query()->where('status', 'active')->count())
                ->badgeColor('success'),
            'terminated' => Tab::make('Terminated employees')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'terminated'))
                ->icon('heroicon-o-x-circle')
                ->iconPosition(IconPosition::Before)
                ->badge(Employee::query()->where('status', 'terminated')->count())
                ->badgeColor('danger'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
