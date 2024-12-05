<?php

namespace App\Filament\Resources\DeviceResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceOwnershipHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'deviceOwnershipHistory';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('service_tag')
                    ->default(fn($livewire) => $livewire->ownerRecord->service_tag)
                    ->required(),
                Forms\Components\Select::make('employee_no')
                    ->relationship('employee', 'name_ar')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Current Owner'),
                Forms\Components\DatePicker::make('assigned_date')
                    ->required(),
                Forms\Components\DatePicker::make('returned_date'),
                Forms\Components\TextInput::make('notes')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_tag')
            ->columns([
                Tables\Columns\TextColumn::make('service_tag'),
                Tables\Columns\TextColumn::make('employee.name_ar'),
                Tables\Columns\TextColumn::make('assigned_date')->date(),
                Tables\Columns\TextColumn::make('returned_date')->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
