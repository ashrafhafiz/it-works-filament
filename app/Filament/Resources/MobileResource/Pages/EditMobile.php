<?php

namespace App\Filament\Resources\MobileResource\Pages;

use App\Filament\Resources\MobileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMobile extends EditRecord
{
    protected static string $resource = MobileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
