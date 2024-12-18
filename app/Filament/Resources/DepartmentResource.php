<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sector;
use Filament\Forms\Get;
use App\Models\Location;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DepartmentResource\Pages;
use App\Filament\Resources\DepartmentResource\RelationManagers;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'System Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

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
        return 'The number of departments';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Department Information')
                    ->description('Information about the department')
                    ->schema([
                        Forms\Components\Select::make('sector_id')
                            ->relationship('sector', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true, modifyRuleUsing: function (Get $get, Unique $rule): Unique {
                                return $rule->where('sector_id', $get('sector_id'));
                            })
                    ])->columnSpan(2),
                Forms\Components\Section::make('Meta data')
                    ->schema([
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn(Department $department): ?string => $department->created_at?->diffForHumans())
                                ->hidden(fn(?Department $department): ?string => $department->id === null),
                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last Updated')
                                ->content(fn(Department $department): ?string => $department->updated_at?->diffForHumans())
                                ->hidden(fn(?Department $department): ?string => $department->id === null),
                        ])->columns(2),
                        Forms\Components\Group::make([
                            Forms\Components\Placeholder::make('created_by')
                                ->label('Created by:')
                                ->content(fn(Department $department): ?string => $department->created_by)
                                ->hidden(fn(?Department $department): ?string => $department->id === null),
                            Forms\Components\Placeholder::make('updated_by')
                                ->label('Updated by:')
                                ->content(fn(Department $department): ?string => $department->updated_by)
                                ->hidden(fn(?Department $department): ?string => $department->id === null),
                        ])->columns(2),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sector.name')
                    ->badge()
                    ->searchable()
                    ->sortable(),
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
                Tables\Filters\Filter::make('status')
                    ->form([
                        Forms\Components\Select::make('sector')
                            ->label('Filter by Sector')
                            ->placeholder('Select a sector')
                            ->options(fn() => Sector::all()->pluck('name', 'id')->toArray()),
                        // Forms\Components\Select::make('location')
                        //     ->label('Filter by Location')
                        //     ->placeholder('Select a location')
                        //     ->options(fn() => Location::all()->pluck('name', 'id')->toArray()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['sector'], function ($query) use ($data) {
                                return $query->where('sector_id', $data['sector']);
                            });
                        // ->when($data['location'], function ($query) use ($data) {
                        //     return $query->where('location_id', $data['location']);
                        // });
                    })
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
