<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Access Control';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->visibleOn('create')
                    ->password()
                    ->required()
                    ->confirmed(),
                Forms\Components\TextInput::make('password_confirmation')
                    ->visibleOn('create')
                    ->password()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('status')
                //     ->badge()
                //     ->color(fn($state) => match ($state) {
                //         'active' => 'success',
                //         'inactive' => 'danger',
                //         default => 'gray'
                //     })
                //     ->icon(fn($state) => match ($state) {
                //         'active' => 'heroicon-o-check-circle',
                //         'inactive' => 'heroicon-o-x-circle',
                //         default => 'heroicon-o-question-mark-circle'
                //     }),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'active' => 'active',
                        'inactive' => 'inactive',
                    ])
                    ->rules(['required'])
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
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
            // ->recordColors(fn($record) => match (true) {
            //     $record->status === 'active' => 'success',
            //     $record->status === 'pending' => 'warning',
            //     $record->status === 'inactive' => 'danger',
            //     default => null
            // })
            // ->striped(function (User $record) {
            //     if ($record->status === 'active') return false;
            //     if ($record->status === 'inactive') return true;
            // })
            ->recordClasses(fn(User $record) => match ($record->status) {
                'active' => 'border-s-2 bg-green-100 dark:bg-green-300',
                'inactive' => 'border-s-2 bg-red-100 dark:bg-red-300',
                default => null,
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('resetPassword')
                    ->form([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->confirmed(),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                        $record->update(['password' => $data['password']]);

                        Notification::make('')
                            ->title('Password Updated Successfully')
                            ->success()
                            ->send();
                    })
                    ->modalWidth(MaxWidth::ExtraLarge)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
