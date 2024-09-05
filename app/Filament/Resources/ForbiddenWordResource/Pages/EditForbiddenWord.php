<?php

namespace App\Filament\Resources\ForbiddenWordResource\Pages;

use App\Filament\Resources\ForbiddenWordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForbiddenWord extends EditRecord
{
    protected static string $resource = ForbiddenWordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
