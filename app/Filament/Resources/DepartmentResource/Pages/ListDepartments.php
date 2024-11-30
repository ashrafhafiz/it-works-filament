<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Imports\DepartmentsImport;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DepartmentResource;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('importDepartments')
                ->label('Import Departments')
                ->icon('heroicon-o-arrow-up-on-square')
                ->color('warning')
                ->form([
                    FileUpload::make('attachement')->required(),
                ])->action(function ($data) {
                    $file = public_path('storage/' . $data['attachement']);
                    (new DepartmentsImport)->import($file, null, \Maatwebsite\Excel\Excel::CSV);
                    Notification::make()
                        ->title('Departments Imported Successfully')
                        ->success()
                        ->send();

                    $recipients = User::where('role', 'admin')->get();
                    Notification::make()
                        ->title('Departments Imported Successfully')
                        ->sendToDatabase($recipients);
                }),
        ];
    }
}
