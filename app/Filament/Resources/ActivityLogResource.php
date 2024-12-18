<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ActivityLog;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ActivityLogResource\Pages;
use App\Filament\Resources\ActivityLogResource\RelationManagers;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'System Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 13;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('log_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event'),
                Tables\Columns\TextColumn::make('subject_id'),
                Tables\Columns\TextColumn::make('causer_type'),
                Tables\Columns\TextColumn::make('causer_id'),
                Tables\Columns\TextColumn::make('properties')
                    ->formatStateUsing(function (Model $record) {
                        return json_decode($record->properties, true);
                    })
                    ->label('Activity Properties'),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),
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
            'index' => Pages\ListActivityLogs::route('/'),
            'create' => Pages\CreateActivityLog::route('/create'),
            'edit' => Pages\EditActivityLog::route('/{record}/edit'),
        ];
    }
}