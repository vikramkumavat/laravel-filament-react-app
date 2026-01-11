<?php

namespace App\Filament\Resources\DatabaseManagerResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DatabaseManagerResource;

class ListDatabaseManagers extends ListRecords
{
    protected static string $resource = DatabaseManagerResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('export_sql')
                ->label('Export Database')
                ->icon('heroicon-o-folder-arrow-down')
                ->action(fn() => DatabaseManagerResource::exportSQL()),
        ];
    }
}
