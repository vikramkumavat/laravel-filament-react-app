<?php

namespace App\Filament\Resources\PropertiesResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PropertiesResource;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make('print')->view('filament.resources.properties.print-button'),
        ];
    }
}
