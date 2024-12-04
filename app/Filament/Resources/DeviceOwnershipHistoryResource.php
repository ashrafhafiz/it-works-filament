<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\DeviceOwnershipHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DeviceOwnershipHistoryResource\Pages;
use App\Filament\Resources\DeviceOwnershipHistoryResource\RelationManagers;
use App\Models\Employee;

class DeviceOwnershipHistoryResource extends Resource
{
    protected static ?string $model = DeviceOwnershipHistory::class;

    protected static ?string $navigationGroup = 'Device Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('service_tag')
                    ->required(),
                Forms\Components\Select::make('employee_no')
                    ->label('Current Owner')
                    // ->options(Employee::all()->pluck('name_ar', 'employee_no'))
                    // ->searchable()
                    ->relationship('employee', 'name_ar')
                    ->required(),
                Forms\Components\DatePicker::make('assigned_date')
                    ->required(),
                Forms\Components\DatePicker::make('returned_date'),
                Forms\Components\TextInput::make('notes')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_tag')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name_ar')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assigned_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('returned_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes')
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
            'index' => Pages\ListDeviceOwnershipHistories::route('/'),
            'create' => Pages\CreateDeviceOwnershipHistory::route('/create'),
            'edit' => Pages\EditDeviceOwnershipHistory::route('/{record}/edit'),
        ];
    }
}