<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Actions;
use App\Models\Employee;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EmployeeResource;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('PDF')
                ->label('Generate PDF')
                ->button()
                ->color('primary')
                ->url(fn(Employee $employee): string => route('generate.employee.pdf', $employee)),
            Actions\Action::make('QrCode')
                ->label('QR Code')
                ->button()
                ->color('warning')
                ->url(function (Employee $record) {
                    return static::getResource()::getUrl('qrCode',  ['record' => $record]);
                }),
        ];
    }
}
