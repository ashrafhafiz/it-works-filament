<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Device extends Model
{
    use HasFactory, LogsActivity;

    protected $primaryKey = 'service_tag'; // Specify the string column as primary key

    // If using a non-incrementing primary key
    public $incrementing = false;

    // Specify the key type as string
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_tag',
        'device_type_id',
        'manufacturer_id',
        'model',
        'status',
        'shipping_date',
        'processor_type',
        'memory_size',
        'storage_size',
        'graphics',
        'sound',
        'ethernet',
        'wireless',
        'display',
        'created_by',
        'updated_by',
        // 'employee_no',
        // 'storage1_size',
        // 'storage2_size',
        // 'graphics_1',
        // 'graphics_2',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'device_type_id' => 'integer',
        'manufacturer_id' => 'integer',
        'shipping_date' => 'date',
        'storage_size' => 'array',
        // 'employee_no' => 'integer',
    ];

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

    // Accessor for CSV
    public function getStorageSizeAttribute($value)
    {
        return json_decode($value);
    }

    // // Mutator for CSV
    // public function setStorageSizeAttribute($value)
    // {
    //     $this->attributes['storage_size'] = is_array($value)
    //         ? json_encode(implode(',', $value))
    //         : json_encode($value);
    //     //     // Ensure value is always an array
    //     //     // $this->attributes['storage_size'] = is_array($value)
    //     //     //     ? json_encode($value)
    //     //     //     : json_encode([$value]);
    // }

    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function deviceOwnershipHistory()
    {
        return $this->hasMany(DeviceOwnershipHistory::class, 'service_tag', 'service_tag');
    }

    // Method to transfer laptop
    public function transferTo(Employee $employee, $notes = null)
    {
        // Create a new ownership history record
        $this->deviceOwnershipHistory()->create([
            'employee_no' => $employee->employee_no,
            'assigned_date' => now(),
            'notes' => $notes
        ]);

        // Update current owner
        $this->update(['employee_no' => $employee->employee_no]);

        return $this;
    }

    // Method to get previous owners
    public function getPreviousOwnersAttribute()
    {
        return $this->deviceOwnershipHistory()
            ->with('employee')
            ->whereNotNull('returned_date')
            ->get();
    }

    public function getCurrentOwnersAttribute()
    {
        return $this->deviceOwnershipHistory()
            ->with('employee')
            ->whereNull('returned_date')
            ->get();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName(class_basename($this) . '_log');
    }
}
