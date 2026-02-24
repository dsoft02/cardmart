<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'password' => 'hashed',
        ];
    }

    /* ============================
     | Role helpers
     |============================ */

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    public function scopeUsers(Builder $query): Builder
    {
        return $query->where('role', self::ROLE_USER);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function pins()
    {
        return $this->hasMany(Pin::class, 'sold_to');
    }

    public function routeFor(string $type): string
    {
        $prefix = $this->isAdmin() ? 'admin.' : 'user.';

        return match ($type) {
            'dashboard' => route($prefix . 'dashboard'),
            'profile'   => route($prefix . 'profile.index'),
            default     => route($prefix . 'dashboard'),
        };
    }

    public function avatarUrl(): Attribute
    {
        return Attribute::get(function () {
            return asset('assets/img/avatars/default.png');
        });
    }

}
