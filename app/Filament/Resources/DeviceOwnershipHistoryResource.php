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
                Forms\Components\TextInput::make('device_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('employee_no')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('assigned_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('returned_date'),
                Forms\Components\TextInput::make('reason')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('device_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee_no')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assigned_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('returned_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
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
