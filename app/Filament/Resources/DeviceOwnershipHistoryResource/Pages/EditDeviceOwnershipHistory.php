<?php

namespace App\Filament\Resources\DeviceOwnershipHistoryResource\Pages;

use App\Filament\Resources\DeviceOwnershipHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeviceOwnershipHistory extends EditRecord
{
    protected static string $resource = DeviceOwnershipHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
