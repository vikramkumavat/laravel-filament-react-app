<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DatabaseManager;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\DatabaseManagerResource\Pages;

class DatabaseManagerResource extends Resource
{
    protected static ?string $model = DatabaseManager::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 99;

    public static function canAccess(): bool
    {
        return /* app()->isLocal() &&  */ \Filament\Facades\Filament::auth()->check()
            && in_array(\Filament\Facades\Filament::auth()->user()->email, config('app.system_access_emails'));
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return DatabaseManager::query()->whereRaw('1 = 0');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDatabaseManagers::route('/'),
        ];
    }

    // Export SQL data
    public static function exportSQL()
    {
        $tables = DB::select('SHOW TABLES');
        $sql = '';

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_" . env('DB_DATABASE')};
            $sql .= self::getTableSQL($tableName);
        }

        return response()->streamDownload(function () use ($sql) {
            echo $sql;
        }, 'database_bk_' . now()->format('Y_m_d_His') . '.sql', [
            'Content-Type' => 'application/sql',
        ]);
    }

    // Generate SQL Dump for a single table
    public static function getTableSQL(string $tableName): string
    {
        $createTableSQL = DB::select("SHOW CREATE TABLE `$tableName`");
        $sql = "DROP TABLE IF EXISTS `$tableName`;\n";
        $sql .= $createTableSQL[0]->{'Create Table'} . ";\n\n";

        $rows = DB::table($tableName)->get();
        foreach ($rows as $row) {
            $values = implode(", ", array_map(
                fn($value) => is_null($value) ? "NULL" : "'" . addslashes($value) . "'",
                (array) $row
            ));

            $columns = implode(", ", array_map(fn($col) => "`$col`", array_keys((array) $row)));

            $sql .= "INSERT INTO `$tableName` ($columns) VALUES ($values);\n";
        }

        $sql .= "\n";
        return $sql;
    }
}
