<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function author(): HasOne
    {
        return $this->hasOne(Author::class);
    }

    /**
     * Helper cepat untuk cek role admin.
     * Dipakai di Filament Resource: auth()->user()->isAdmin()
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAuthor(): bool
    {
        return $this->role === 'author';
    }

    /**
     * Semua user (admin & author) boleh login ke panel Filament.
     * Pembatasan akses per-resource diatur di masing-masing Resource.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
