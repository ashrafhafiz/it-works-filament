<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Division extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'division_id',
        'division_name_ar',
        'division_name_en',
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
        'division_id' => 'integer',
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

    public function parentDivision()
    {
        return $this->belongsTo(Division::class, 'parent_division_id', 'division_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName(class_basename($this) . '_log');
    }
}
