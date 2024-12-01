<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasPanelShield;

    public function canAccessPanel(Panel $panel): bool
    {
        // return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
        return str_ends_with($this->email, '@example.com') && $this->hasVerifiedEmail();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'is_active',
        'last_login_timestamp',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_timestamp' => 'datetime',
            'password' => 'hashed',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ];
    }

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
        $adminUser = self::where('email', 'admin@example.com')->first();

        // If no admin exists, create one
        if (!$adminUser) {
            $adminUser = self::create([
                'name' => 'System Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'type' => 'admin',
                'is_active' => true,
                'last_login_timestamp' => now(),
                'created_by' => 1,
                'remember_token' => Str::random(10),
            ]);
        }

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

    public function updateLastLogin()
    {
        $this->last_login_timestamp = now();
        $this->save();
        //
        // Security Considerations: To prevent constant updates on every request, you might want to limit updates
        // Only update if last login was more than 5 minutes ago
        // if (!$this->last_login_timestamp || now()->diffInMinutes($this->last_login_timestamp) > 5) {
        //     $this->last_login_timestamp = now();
        //     $this->save();
        // }
    }
}