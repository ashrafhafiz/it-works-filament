<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectorResource\Pages;
use App\Filament\Resources\SectorResource\RelationManagers;
use App\Models\Location;
use App\Models\Sector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectorResource extends Resource
{
    protected static ?string $model = Sector::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'System Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-s-rectangle-group';

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
        return 'The number of sectors';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sector Information')
                    ->description('Information about the Sector')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('locations')
                            ->relationship('locations', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->visibleOn('create'),
                        ])->columnSpan(2),
                Forms\Components\Section::make('Meta data')
                    ->schema([
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (Sector $sector): ?string => $sector->created_at?->diffForHumans())
                                ->hidden(fn (?Sector $sector): ?string => $sector->id === null),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last Updated')
                                ->content(fn (Sector $sector): ?string => $sector->updated_at?->diffForHumans())
                                ->hidden(fn (?Sector $sector): ?string => $sector->id === null),
                        ])->columns(2),
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('created_by')
                                ->label('Created by:')
                                ->content(fn (Sector $sector): ?string => $sector->created_by)
                                ->hidden(fn (?Sector $sector): ?string => $sector->id === null),
                            Forms\Components\Placeholder::make('updated_by')
                                ->label('Updated by:')
                                ->content(fn (Sector $sector): ?string => $sector->updated_by)
                                ->hidden(fn (?Sector $sector): ?string => $sector->id === null),
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
                Tables\Columns\TextColumn::make('departments.name')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('locations.name')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employees_count')
                    ->label('Active Employees Count')
                    // the following is not working
                    // ->counts(
                    //     'employees',
                    //     fn(Builder $query) => $query->where('status', 'active')
                    // )
                    // the following is not working also
                    // ->counts(
                    //     'employees',
                    //     fn(Builder $query) => $query->active()
                    // )
                    // The following is working
                    // ->getStateUsing(function ($record) {
                    //     return $record->employees()->where('status', 'active')->count();
                    // })
                    // using a scoped method in the model class
                    ->getStateUsing(function ($record) {
                        return $record->employees()->active()->count();
                    })
                    ->badge()
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
            RelationManagers\LocationsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSectors::route('/'),
            'create' => Pages\CreateSector::route('/create'),
            'edit' => Pages\EditSector::route('/{record}/edit'),
        ];
    }
}
