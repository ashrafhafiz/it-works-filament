<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Support\Facades\Auth;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Employee extends Authenticatable implements HasName
{
    use HasFactory, LogsActivity;

    protected $guard = 'employee';

    protected $primaryKey = 'employee_no';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_no',
        'name_ar',
        'name_en',
        'email',
        'password',
        'hiring_date',
        'birth_date',
        'status',
        'company',
        'government_id',
        'graduation_id',
        'division_id',
        'parent_division_id',
        'job_title_id',
        'nationality_id',
        'religion_id',
        'mobile_1',
        'national_id',
        'address',
        'gender',
        'class',
        'report_to',
        'location_id',
        'sector_id',
        'department_id',
        'last_login_timestamp',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'government_id' => 'integer',
        'graduation_id' => 'integer',
        'division_id' => 'integer',
        'parent_division_id' => 'integer',
        'job_title_id' => 'integer',
        'nationality_id' => 'integer',
        'religion_id' => 'integer',
        'report_to' => 'integer',
        'location_id' => 'integer',
        'sector_id' => 'integer',
        'department_id' => 'integer',
        'employee_no' => 'integer',
        'last_login_timestamp' => 'datetime',
        'password' => 'hashed',
        'hiring_date' => 'date',
        'birth_date' => 'date',
    ];

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     // return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    //     return str_ends_with($this->email, '@example.com') && $this->hasVerifiedEmail();
    // }

    protected static function booted()
    {
        // Automatically set created_by and updated_by when creating or updating
        static::creating(function ($model) {
            // If no created_by is set, try to use authenticated user
            if (Auth::check()) {
                $model->created_by = User::find(Auth::id())->name;
            } else {
                // Fallback to a default admin user or first user
                $model->created_by = self::getDefaultAdminId();
            }
        });

        static::updating(function ($model) {
            // If no updated_by is set, try to use authenticated user
            if (Auth::check()) {
                $model->updated_by = User::find(Auth::id())->name;
            } else {
                // Fallback to a default admin user or first user
                $model->updated_by = self::getDefaultAdminId();
            }
        });
    }

    // Helper method to get a default admin ID for seeding
    protected static function getDefaultAdminId()
    {
        // Try to find an existing admin user
        // return User::where('email', 'admin@example.com')->first()->name;
        return 'System';
    }

    public function getFilamentName(): string
    {
        return $this->name_en;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeTerminated($query)
    {
        return $query->where('status', 'terminated');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class);
    }

    public function government(): BelongsTo
    {
        return $this->belongsTo(Government::class);
    }

    public function graduation(): BelongsTo
    {
        return $this->belongsTo(Graduation::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id', 'division_id');
    }

    public function parentDivision(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'parent_division_id', 'parent_division_id');
    }

    public function jobTitle(): BelongsTo
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id', 'job_title_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    // Get the supervisor/manager
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'report_to');
    }

    // Get direct reports (subordinates)
    public function directReports(): HasMany
    {
        return $this->hasMany(Employee::class, 'report_to');
    }

    public function mobiles(): HasMany
    {
        return $this->hasMany(Mobile::class, 'employee_no');
    }

    // public function devices(): HasMany
    // {
    //     return $this->hasMany(Device::class, 'employee_no');
    // }

    public function deviceOwnershipHistory()
    {
        return $this->hasMany(DeviceOwnershipHistory::class, 'employee_no', 'employee_no');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName(class_basename($this) . '_log');
    }
}
