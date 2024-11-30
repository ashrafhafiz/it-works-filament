<?php

namespace App\Models;

use Filament\Panel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Employee extends Authenticatable implements HasName
{
    use HasFactory;

    protected $guard = 'employee';

    protected $primaryKey = 'employee_no';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'email',
        'password',
        'status',
        'company',
        'job_title',
        'class',
        'national_id',
        'employee_no',
        'report_to',
        'location_id',
        'sector_id',
        'department_id',
        'last_login_timestamp'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'report_to' => 'integer',
        'location_id' => 'integer',
        'sector_id' => 'integer',
        'department_id' => 'integer',
        'employee_no' => 'integer',
        'last_login_timestamp' => 'datetime',
        'password' => 'hashed',
    ];

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     // return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    //     return str_ends_with($this->email, '@example.com') && $this->hasVerifiedEmail();
    // }

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

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'employee_no');
    }
}
