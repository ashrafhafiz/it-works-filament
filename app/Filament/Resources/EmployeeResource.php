<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'Employee Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_ar')
                    ->hint('This is hint!')
                    ->label('Name (عربي)')
                    ->required(),
                Forms\Components\TextInput::make('name_en')
                    ->label('Name (en)')
                    ->markAsRequired(true),
                Forms\Components\TextInput::make('email')
                    ->email(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'terminated' => 'Terminated',
                    ])
                    ->default('active')
                    ->required()
                    ->prefixIcon(function ($state) {
                        return match ($state) {
                            'active' => 'heroicon-o-check-circle',
                            'inactive' => 'heroicon-o-pause-circle',
                            'terminated' => 'heroicon-o-x-circle',
                            default => null,
                        };
                    })
                    ->prefixIconColor(function ($state) {
                        return match ($state) {
                            'active' => 'success',
                            'inactive' => 'warning',
                            'terminated' => 'danger',
                            default => null,
                        };
                    }),
                Forms\Components\TextInput::make('company')
                    ->required(),
                Forms\Components\TextInput::make('job_title')
                    ->required(),
                Forms\Components\Select::make('class')
                    ->options([
                        'White Collars' => 'White Collars',
                        'Blue Collars' => 'Blue Collars',
                    ])
                    ->default('White Collars')
                    ->required()
                    ->prefixIcon(function ($state) {
                        return match ($state) {
                            'White Collars' => 'heroicon-o-user',
                            'Blue Collars' => 'heroicon-o-user',
                            default => null,
                        };
                    })
                    ->prefixIconColor(function ($state) {
                        return match ($state) {
                            'White Collars' => Color::Gray,
                            'Blue Collars' => Color::Blue,
                            default => null,
                        };
                    }),
                Forms\Components\TextInput::make('national_id')
                    ->required(),
                Forms\Components\TextInput::make('employee_no')
                    ->required(),
                Forms\Components\Select::make('report_to')
                    ->relationship('manager', 'name_ar'),
                Forms\Components\Select::make('location_id')
                    ->relationship('location', 'name')
                    ->required(),
                Forms\Components\Select::make('sector_id')
                    ->relationship('sector', 'name')
                    ->required(),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('Name (ar)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (en)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('class')
                    ->searchable(),
                Tables\Columns\TextColumn::make('national_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('report_to')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sector.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}