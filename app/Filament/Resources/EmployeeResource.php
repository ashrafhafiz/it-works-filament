<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sector;
use Filament\Forms\Get;
use App\Models\Employee;
use App\Models\Location;
use Filament\Forms\Form;
use App\Models\Department;
use Filament\Tables\Table;
use App\Exports\EmployeesExport;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use App\Services\TextMessageService;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    // Optional: Assign to a group
    protected static ?string $navigationGroup = 'Employee Management';

    // Optional: Sort within the group
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                    ->relationship('manager', 'name_ar')
                    ->searchable(),
                Forms\Components\Select::make('location_id')
                    ->relationship('location', 'name')
                    ->required(),
                Forms\Components\Select::make('sector_id')
                    ->live()
                    ->relationship('sector', 'name')
                    ->required(),
                Forms\Components\Select::make('department_id')
                    // ->relationship('department', 'name'),
                    ->options(function (Get $get) {
                        $sectorId = $get('sector_id');
                        if ($sectorId) {
                            // return Department::where('sector_id', $sectorId)->get()->pluck('name', 'id');
                            return Department::where('sector_id', $sectorId)->pluck('name', 'id')->toArray();
                        }
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_no')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('Name (ar)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (en)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('company')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('job_title.job_title_name_ar'),
                Tables\Columns\TextColumn::make('class')
                    ->badge(),
                Tables\Columns\TextColumn::make('national_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manager.name_ar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nationality.nationality_name_ar')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('religion.religion_name_ar')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('government.government_name_ar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('graduation.graduation_name_ar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('division.division_name_ar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('division.parentDivision.division_name_ar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jobTitle.job_title_name_ar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sector.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_by')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_by')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('hiring_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
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
                        Forms\Components\Select::make('class')
                            ->label('Filter by Class')
                            ->placeholder('Select a Class')
                            ->options([
                                'White Collars' => 'White Collars',
                                'Blue Collars' => 'Blue Collars',
                            ]),
                        Forms\Components\Select::make('status')
                            ->label('Filter by Status')
                            ->placeholder('Select a Status')
                            ->options([
                                'Active' => 'active',
                                'Terminated' => 'terminated'
                            ]),
                        Forms\Components\Select::make('location')
                            ->label('Filter by Location')
                            ->placeholder('Select a location')
                            ->options(fn() => Location::all()->pluck('name', 'id')->toArray()),
                        Forms\Components\Select::make('sector')
                            ->label('Filter by Sector')
                            ->placeholder('Select a sector')
                            ->options(fn() => Sector::all()->pluck('name', 'id')->toArray()),
                        Forms\Components\Select::make('department')
                            ->label('Filter by Department')
                            ->placeholder('Select a department')
                            ->options(function (Get $get) {
                                $sectorId = $get('sector');
                                if ($sectorId) {
                                    return Department::where('sector_id', $sectorId)->pluck('name', 'id')->toArray();
                                } else {
                                    return Department::all()->pluck('name', 'id')->toArray();
                                }
                            })
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['class'], function ($query) use ($data) {
                                return $query->where('class', $data['class']);
                            })
                            ->when($data['status'], function ($query) use ($data) {
                                return $query->where('status', $data['status']);
                            })
                            ->when($data['location'], function ($query) use ($data) {
                                return $query->where('location_id', $data['location']);
                            })
                            ->when($data['sector'], function ($query) use ($data) {
                                return $query->where('sector_id', $data['sector']);
                            })
                            ->when($data['department'], function ($query) use ($data) {
                                return $query->where('department_id', $data['department']);
                            });
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('PDF')
                    ->label('Generate PDF')
                    ->url(fn(Employee $employee): string => route('generate.employee.pdf', $employee)),
                Tables\Actions\Action::make('QrCode')
                    ->label('QR Code')
                    ->url(function (Employee $record) {
                        return static::getUrl('qrCode', ['record' => $record]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('Export')
                        ->label('Export to Excel')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Collection $records) {
                            return Excel::download(new EmployeesExport($records), 'employees.xlsx');
                        }),

                    Tables\Actions\BulkAction::make('sendBulkSms')
                        ->label('Send Bulk SMS')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->deselectRecordsAfterCompletion()
                        ->modalSubmitActionLabel('Send Message')
                        ->form([
                            Forms\Components\Textarea::make('message')
                                ->placeholder('Enter a message')
                                ->required()
                                ->maxLength(255)
                                ->rows(4),
                            Forms\Components\Textarea::make('remarks')
                                ->placeholder('Enter a remarks')
                                ->maxLength(255),
                        ])->action(function (Collection $records, array $data) {
                            TextMessageService::sendBulkSms($records, $data);

                            Notification::make('')
                                ->title('Messages Sent Successfully')
                                ->success()
                                ->send();
                        })
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
            'qrCode' => Pages\GenerateEmployeeQrCode::route('/{record}/generateqrcode')
        ];
    }
}