<?php

namespace App\Filament\Resources\DeviceOwnershipHistoryResource\Pages;

use App\Filament\Resources\DeviceOwnershipHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListDeviceOwnershipHistories extends ListRecords
{
    protected static string $resource = DeviceOwnershipHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()->orderByDesc('assigned_date');
    }
}
