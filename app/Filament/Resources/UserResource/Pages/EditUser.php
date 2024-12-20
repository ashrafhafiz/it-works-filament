<?php

namespace App\Filament\Resources\UserResource\Pages;

use Schema;
use Filament\Actions;
use Filament\Support\Enums\MaxWidth;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('updatePassword')
                ->form([
                    TextInput::make('password')
                        ->password()
                        ->required()
                        ->confirmed(),
                    TextInput::make('password_confirmation')
                        ->password()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update(['password' => $data['password']]);

                    Notification::make('')
                        ->title('Password Updated Successfully')
                        ->success()
                        ->send();
                })
                ->modalWidth(MaxWidth::ExtraLarge)
        ];
    }

    protected function getSavedNotificationTitle(): string|null
    {
        return "The user was updated successfully.";
    }
}
