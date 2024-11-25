<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use Filament\Actions;
use App\Models\Device;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\DeviceResource;

class EditDevice extends EditRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('PDF')
                ->label('PDF')
                ->button()
                ->color('primary')
                ->url(fn(Device $device): string => route('generate.device.pdf', $device)),
            Actions\Action::make('QrCode')
                ->label('QR Code')
                ->button()
                ->color('warning')
                ->url(function (Device $record) {
                    return static::getResource()::getUrl('qrCode', ['record' => $record]);
                }),
        ];
    }
}
