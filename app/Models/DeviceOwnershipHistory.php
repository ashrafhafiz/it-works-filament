<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceOwnershipHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_tag',
        'employee_no',
        'assigned_date',
        'returned_date',
        'notes',
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
        'employee_no' => 'integer',
        'assigned_date' => 'date',
        'returned_date' => 'date',
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

    public function device()
    {
        return $this->belongsTo(Device::class, 'service_tag', 'service_tag');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_no', 'employee_no');
    }
}