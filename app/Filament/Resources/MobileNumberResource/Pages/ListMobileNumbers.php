<?php

namespace App\Filament\Resources\MobileNumberResource\Pages;

use App\Filament\Resources\MobileNumberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMobileNumbers extends ListRecords
{
    protected static string $resource = MobileNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
