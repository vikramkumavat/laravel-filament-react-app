<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Http\Request;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PropertiesResource\Pages;
use Barryvdh\DomPDF\Facade\Pdf;

class PropertiesResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('owner_name')
                ->label('Borrower Name')
                ->maxLength(65535)
                ->required(),

            TextInput::make('bank_name')
                ->label('Bank Name')
                ->maxLength(255)
                ->required(),

            Select::make('property_type_id')
                ->label('Property Type')
                ->relationship('type', 'name')
                ->required(),

            TextInput::make('sq_ft')
                ->label('Square Feet')
                ->numeric()
                ->suffix('sq ft')
                ->required(),

            TextInput::make('price')
                ->label('Price')
                ->numeric()
                ->minValue(0)
                ->prefix('₹')
                ->lazy()->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                    $commission = is_numeric($state) ? ($state * (env('EMD_PERCENTAGE', 10) / 100)) : null;
                    $set('emd_price', $commission);
                }),

            TextInput::make('emd_price')
                ->label('EMD Price')
                ->numeric()
                ->required()
                ->prefix('₹')
                ->minValue(0),

            TextInput::make('location')
                ->label('Location')
                ->maxLength(255),

            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'done' => 'Done',
                ])
                ->label('Status'),

            // TextInput::make('starting_price')
            //     ->label('Starting Price')
            //     ->numeric()
            //     ->minValue(0)
            //     ->step(0.01),

            // FileUpload::make('image')
            //     ->label('Image')
            //     ->image()
            //     ->directory('properties')
            //     // ->imagePreviewHeight('150')
            //     ->imageCropAspectRatio('16:9')
            //     ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Property Id')
                    ->formatStateUsing(fn($record) => "Property #{$record->id}")
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type.name')
                    ->label('Property Type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('owner_name')
                    ->label('Borrower Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location')
                    ->searchable()
                    ->tooltip(fn($record) => $record->location) // Optional: show full text on hover
                    ->limit(20) // 👈 Truncate to 20 characters
                    ->sortable(),

                TextColumn::make('price')
                    ->money('INR')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sq_ft')
                    ->label('Sq Ft')
                    ->searchable()
                    ->suffix(' sq ft')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->date()
                    ->label('Created')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // 👈 Default sort
            ->filters([
                Filter::make('price_range')
                    ->form([
                        TextInput::make('min_price')
                            ->numeric()
                            ->label('Min Price'),

                        TextInput::make('max_price')
                            ->numeric()
                            ->label('Max Price'),
                    ])
                    ->query(
                        fn(Builder $query, array $data): Builder =>
                        $query
                            ->when(
                                $data['min_price'],
                                fn($q) => $q->where('price', '>=', $data['min_price'])
                            )
                            ->when(
                                $data['max_price'],
                                fn($q) => $q->where('price', '<=', $data['max_price'])
                            )
                    ),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'done' => 'Done',
                    ]),
            ])
            ->headerActions([
                // 
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperties::route('/create'),
            'edit' => Pages\EditProperties::route('/{record}/edit'),
        ];
    }

    public static function print(Request $request)
    {
        $query = PropertiesResource::getEloquentQuery();

        // Apply status filter
        if (!empty($request->get('tableFilters')['status']['value'])) {
            $query->where('status', $request->get('tableFilters')['status']['value']);
        }

        // Apply location filter
        if (!empty($request->get('tableFilters')['location']['value'])) {
            $query->where('location', 'like', '%' . $request->get('tableFilters')['location']['value'] . '%');
        }

        // Apply price range filter
        $priceFilter = $request->get('tableFilters')['price_range'] ?? [];
        if (!empty($priceFilter['min_price'])) {
            $query->where('price', '>=', $priceFilter['min_price']);
        }
        if (!empty($priceFilter['max_price'])) {
            $query->where('price', '<=', $priceFilter['max_price']);
        }

        // Apply search
        if ($request->filled('tableSearch')) {
            $search = $request->get('tableSearch');
            $query->where(function ($q) use ($search) {
                $q->orWhereHas('type', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('sq_ft', 'like', "%{$search}%")
                    ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        if ($request->filled('tableSortColumn') && $request->filled('tableSortDirection')) {
            $query->orderBy($request->get('tableSortColumn'), $request->get('tableSortDirection'));
        }

        $properties = $query->get();

        // Load the Blade view into a PDF
        $pdf = Pdf::loadView('filament.resources.properties.print-to-pdf', compact('properties'));

        // Download the PDF
        $dtTime = now()->format('Y-m-d_H-i-s');
        return $pdf->download("properties-list-$dtTime.pdf");

        // return view('filament.resources.properties.print', compact('properties'));
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['type']) // eager load if needed
            ->orderBy('created_at', 'desc');
    }
}
