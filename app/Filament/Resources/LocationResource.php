<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Location;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LocationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LocationResource\RelationManagers;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'System Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-c-building-office';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'The number of locations';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Location Information')
                    ->description('Information about the location')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('address')
                            ->required(),
                        Forms\Components\TextInput::make('city')
                            ->required(),
                        Forms\Components\TextInput::make('postal_code'),
                        Forms\Components\TextInput::make('country')
                            ->required(),
                    ])->columnSpan(2),
                Forms\Components\Section::make('Meta data')
                    ->schema([
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn(Location $location): ?string => $location->created_at?->diffForHumans())
                                ->hidden(fn(?Location $location): ?string => $location->id === null),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last Updated')
                                ->content(fn(Location $location): ?string => $location->updated_at?->diffForHumans())
                                ->hidden(fn(?Location $location): ?string => $location->id === null),

                        ])->columns(2),
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('created_by')
                                ->label('Created by:')
                                ->content(fn(Location $location): ?string => $location->created_by)
                                ->hidden(fn(?Location $location): ?string => $location->id === null),
                            Forms\Components\Placeholder::make('updated_by')
                                ->label('Updated by:')
                                ->content(fn(Location $location): ?string => $location->updated_by)
                                ->hidden(fn(?Location $location): ?string => $location->id === null),

                        ])->columns(2),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sectors.name')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_by')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
