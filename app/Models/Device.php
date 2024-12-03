<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'service_tag',
        'processor_type',
        'memory_size',
        'storage_size',
        'graphics',
        // 'storage1_size',
        // 'storage2_size',
        // 'graphics_1',
        // 'graphics_2',
        'sound',
        'ethernet',
        'wireless',
        'display',
        'shipping_date',
        'status',
        'employee_no',
        'manufacturer_id',
        'device_type_id',
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
        'shipping_date' => 'date',
        'employee_no' => 'integer',
        'manufacturer_id' => 'integer',
        'device_type_id' => 'integer',
        'storage_size' => 'array',
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


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_no');
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function currentOwner()
    {
        return $this->belongsTo(Employee::class, 'employee_no');
    }

    public function ownershipHistories()
    {
        return $this->hasMany(DeviceOwnershipHistory::class);
    }

    // Method to transfer laptop
    public function transferTo(Employee $employee, $reason = null)
    {
        // Create a new ownership history record
        $this->ownershipHistories()->create([
            'employee_no' => $employee->employee_no,
            'assigned_date' => now(),
            'reason' => $reason
        ]);

        // Update current owner
        $this->update(['employee_no' => $employee->employee_no]);

        return $this;
    }

    // Method to get previous owners
    public function getPreviousOwnersAttribute()
    {
        return $this->ownershipHistories()
            ->with('employee')
            ->whereNotNull('returned_date')
            ->get();
    }
}
