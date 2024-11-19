<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MobileResource\Pages;
use App\Filament\Resources\MobileResource\RelationManagers;
use App\Models\Mobile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MobileResource extends Resource
{
    protected static ?string $model = Mobile::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'Employee Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'name_ar')
                    ->required(),
                Forms\Components\TextInput::make('mobile_no'),
                Forms\Components\TextInput::make('rate_plan'),
                Forms\Components\TextInput::make('bouquet_value')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name_ar')
                    // ->relationship('employee', 'name_ar')
                    // ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_no')
                    ->formatStateUsing(fn($state) => '0' . $state)
                    ->extraAttributes(['class' => 'font-mono bg-gray-100 text-red-700'])
                    ->color('danger')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rate_plan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bouquet_value')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListMobiles::route('/'),
            'create' => Pages\CreateMobile::route('/create'),
            'edit' => Pages\EditMobile::route('/{record}/edit'),
        ];
    }
}