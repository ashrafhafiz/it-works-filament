<?php

namespace App\Filament\Resources\GovernmentResource\Pages;

use App\Filament\Resources\GovernmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGovernments extends ManageRecords
{
    protected static string $resource = GovernmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
