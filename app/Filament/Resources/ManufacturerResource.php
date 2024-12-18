<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Tables\Table;
use App\Models\Manufacturer;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ManufacturerResource\Pages;
use App\Filament\Resources\ManufacturerResource\RelationManagers;

class ManufacturerResource extends Resource
{
    protected static ?string $model = Manufacturer::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'System Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

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
        return 'The number of manufacturers';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Manufacturer Information')
                    ->description('Information about the manufacturer')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ])->columnSpan(2),
                Forms\Components\Section::make('Meta data')
                    ->schema([
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn(Manufacturer $manufacturer): ?string => $manufacturer->created_at?->diffForHumans())
                                ->hidden(fn(?Manufacturer $manufacturer): ?string => $manufacturer->id === null),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last Updated')
                                ->content(fn(Manufacturer $manufacturer): ?string => $manufacturer->updated_at?->diffForHumans())
                                ->hidden(fn(?Manufacturer $manufacturer): ?string => $manufacturer->id === null),
                        ])->columns(2),
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('created_by')
                                ->label('Created by:')
                                ->content(fn(Manufacturer $manufacturer): ?string => $manufacturer->created_by)
                                ->hidden(fn(?Manufacturer $manufacturer): ?string => $manufacturer->id === null),
                            Forms\Components\Placeholder::make('updated_by')
                                ->label('Updated by:')
                                ->content(fn(Manufacturer $manufacturer): ?string => $manufacturer->updated_by)
                                ->hidden(fn(?Manufacturer $manufacturer): ?string => $manufacturer->id === null),
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
                Tables\Columns\TextColumn::make('created_by')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_by')
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageManufacturers::route('/'),
        ];
    }
}
