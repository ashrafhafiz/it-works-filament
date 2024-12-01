<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sector extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_sector', 'sector_id', 'location_id')->withTimestamps();
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}