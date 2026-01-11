<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Auction;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\AuctionResource\Pages;

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Auctions';
    protected static ?string $modelLabel = 'Auction';
    protected static ?string $pluralModelLabel = 'Auctions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Select::make('property_id')
                        ->relationship('property', 'id', fn($query) => $query->with('type')->where('status', 'pending'))
                        ->getOptionLabelFromRecordUsing(
                            fn($record) => "Property #{$record->id} ({$record->type->name}) - {$record->owner_name}"
                        )
                        ->searchable()
                        ->preload()
                        ->label('Property')
                        ->required(),

                    TextInput::make('location')
                        ->label('Location')
                        ->required(),

                    DatePicker::make('start_time')
                        ->label('Start Time'),

                    Textarea::make('description')
                        ->label('Description')
                        ->rows(4)
                        ->nullable(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('id')
                //     ->sortable(),

                TextColumn::make('property.type.name')
                    ->label('Property Type')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('location')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('start_time')
                    ->sortable()
                    ->date()
                    ->label('Start Time'),
            ])
            ->defaultSort('created_at', 'desc') // 👈 Default sort
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ActionGroup::make([
                // ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuctions::route('/'),
            'create' => Pages\CreateAuction::route('/create'),
            'edit' => Pages\EditAuction::route('/{record}/edit'),
        ];
    }
}
