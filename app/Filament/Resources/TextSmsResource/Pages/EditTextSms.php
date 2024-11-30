<?php

namespace App\Filament\Resources\TextSmsResource\Pages;

use App\Filament\Resources\TextSmsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTextSms extends EditRecord
{
    protected static string $resource = TextSmsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
