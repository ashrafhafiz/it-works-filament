<?php

namespace App\Filament\Resources\MobileResource\Pages;

use App\Filament\Resources\MobileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMobiles extends ListRecords
{
    protected static string $resource = MobileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
