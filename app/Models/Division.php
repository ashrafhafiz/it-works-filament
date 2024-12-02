<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
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
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected static function booted()
    {
        // Automatically set created_by and updated_by when creating or updating
        static::creating(function ($model) {
            // If no created_by is set, try to use authenticated user
            if (empty($model->created_by)) {
                if (Auth::check()) {
                    $model->created_by = Auth::id();
                } else {
                    // Fallback to a default admin user or first user
                    $defaultAdminId = self::getDefaultAdminId();
                    $model->created_by = $defaultAdminId;
                }
            }
        });

        static::updating(function ($model) {
            // If no updated_by is set, try to use authenticated user
            if (empty($model->updated_by)) {
                if (Auth::check()) {
                    $model->updated_by = Auth::id();
                } else {
                    // Fallback to a default admin user or first user
                    $defaultAdminId = self::getDefaultAdminId();
                    $model->updated_by = $defaultAdminId;
                }
            }
        });
    }

    // Helper method to get a default admin ID for seeding
    protected static function getDefaultAdminId()
    {
        // Try to find an existing admin user
        $adminUser = User::where('email', 'admin@example.com')->first();

        return $adminUser->id;
    }

    // Relationship to track who created the user
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship to track who last updated the user
    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}