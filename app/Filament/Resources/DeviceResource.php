<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'Device Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('service_tag')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Select::make('device_type_id')
                    ->relationship('deviceType', 'type')
                    ->required(),
                Forms\Components\Select::make('manufacturer_id')
                    ->relationship('manufacturer', 'name')
                    ->required(),
                Forms\Components\TextInput::make('model')
                    ->required(),
                Forms\Components\TextInput::make('processor_type')
                    ->required(),
                Forms\Components\TextInput::make('memory_size')
                    ->required(),
                Forms\Components\TextInput::make('storage_size')
                    ->required(),
                // Forms\Components\TextInput::make('storage1_size')
                //     ->required(),
                // Forms\Components\TextInput::make('storage2_size')
                //     ->required(),
                Forms\Components\TextInput::make('graphics')
                    ->required(),
                // Forms\Components\TextInput::make('graphics_1')
                //     ->required(),
                // Forms\Components\TextInput::make('graphics_2')
                //     ->required(),
                Forms\Components\TextInput::make('sound')
                    ->required(),
                Forms\Components\TextInput::make('ethernet')
                    ->required(),
                Forms\Components\TextInput::make('wireless')
                    ->required(),
                Forms\Components\TextInput::make('display')
                    ->required(),
                Forms\Components\DatePicker::make('shipping_date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('employee.name_ar')
                //     ->searchable()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('service_tag')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deviceType.type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('manufacturer.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_owner')
                    // ->searchable()
                    ->label('Current Owner')
                    ->getStateUsing(function (Device $record) {
                        // Get the most recent active ownership history
                        $currentOwnership = $record->deviceOwnershipHistory()
                            ->whereNull('returned_date')
                            ->with('employee')
                            ->latest('assigned_date')
                            ->first();

                        return $currentOwnership
                            ? $currentOwnership->employee->name_ar
                            : 'Not Assigned';
                    })
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('shipping_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('processor_type')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('memory_size')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('storage_size')
                    // ->formatStateUsing(function ($state) {
                    // if (!is_array($state)) return 'N/A';
                    // return collect($state)
                    // ->map(fn($spec) => "{$spec['key']}: {$spec['value']}")
                    // ->implode(', ');
                    // })
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('storage1_size')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('storage2_size')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('graphics')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('graphics_1')
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('graphics_2')
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sound')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ethernet')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('wireless')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('display')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\Action::make('PDF')
                    ->label('PDF')
                    ->button()
                    ->color('danger')
                    ->url(fn(Device $device): string => route('generate.device.pdf', $device)),
                Tables\Actions\Action::make('QrCode')
                    ->label('QR Code')
                    ->button()
                    ->color('primary')
                    ->url(function (Device $record) {
                        return static::getUrl('qrCode', ['record' => $record]);
                    }),
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
            RelationManagers\DeviceOwnershipHistoryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
            'qrCode' => Pages\GenerateDeviceQrCode::route('/{record}/generateqrcode')
        ];
    }
}