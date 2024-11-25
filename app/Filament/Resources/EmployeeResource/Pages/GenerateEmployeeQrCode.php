<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Resources\Pages\Page;
use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class GenerateEmployeeQrCode extends Page
{
    use InteractsWithRecord;

    protected static string $resource = EmployeeResource::class;

    protected static string $view = 'filament.resources.employee-resource.pages.generate-employee-qr-code';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        static::authorizeResourceAccess();
    }
}
