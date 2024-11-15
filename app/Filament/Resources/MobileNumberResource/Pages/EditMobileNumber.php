<?php

namespace App\Filament\Resources\MobileNumberResource\Pages;

use App\Filament\Resources\MobileNumberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMobileNumber extends EditRecord
{
    protected static string $resource = MobileNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
