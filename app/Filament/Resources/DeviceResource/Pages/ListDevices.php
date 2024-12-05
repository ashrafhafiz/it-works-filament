<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use Filament\Actions;
use App\Models\Device;
use Filament\Resources\Components\Tab;
use Filament\Support\Enums\IconPosition;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DeviceResource;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All devices')
                ->badge(Device::all()->count())
                ->badgeColor('primary'),
            'active' => Tab::make('Active')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'active'))
                ->icon('heroicon-o-shield-check')
                ->iconPosition(IconPosition::Before)
                ->badge(Device::query()->where('status', 'active')->count())
                ->badgeColor('success'),
            'available' => Tab::make('Available')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'available'))
                ->icon('heroicon-o-shield-check')
                ->iconPosition(IconPosition::Before)
                ->badge(Device::query()->where('status', 'available')->count())
                ->badgeColor('warning'),
            'reserved' => Tab::make('Reserved')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'reserved'))
                ->icon('heroicon-o-shield-check')
                ->iconPosition(IconPosition::Before)
                ->badge(Device::query()->where('status', 'reserved')->count())
                ->badgeColor('danger'),
            'repair' => Tab::make('Repair')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'repair'))
                ->icon('heroicon-o-x-circle')
                ->iconPosition(IconPosition::Before)
                ->badge(Device::query()->where('status', 'repair')->count())
                ->badgeColor('danger'),
            'retired' => Tab::make('Retired')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'retired'))
                ->icon('heroicon-o-x-circle')
                ->iconPosition(IconPosition::Before)
                ->badge(Device::query()->where('status', 'retired')->count())
                ->badgeColor('danger'),
        ];
    }
}
