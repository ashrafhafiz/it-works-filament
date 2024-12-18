<?php

namespace App\Filament\Resources\SectorResource\Pages;

use App\Filament\Resources\SectorResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSector extends EditRecord
{
    protected static string $resource = SectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    //    protected function getSavedNotificationTitle(): ?string
    //    {
    //        return 'Sector has been updated successfully.'; // TODO: Change the autogenerated stub
    //    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Sector updated')
            ->body('The Sector has been saved successfully.');
    }
}
