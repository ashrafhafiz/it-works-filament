<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

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
    ];

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
