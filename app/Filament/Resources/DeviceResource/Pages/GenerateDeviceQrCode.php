<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use Filament\Resources\Pages\Page;
use App\Filament\Resources\DeviceResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class GenerateDeviceQrCode extends Page
{
    use InteractsWithRecord;

    protected static string $resource = DeviceResource::class;

    protected static string $view = 'filament.resources.device-resource.pages.generate-device-qr-code';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        static::authorizeResourceAccess();
    }
}
