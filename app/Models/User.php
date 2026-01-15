<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ProfilPengunjung;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    /**
     * Konfigurasi logging aktivitas untuk model User.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email']) // Hanya log perubahan pada 'name' dan 'email'
            ->dontLogIfAttributesChangedOnly(['password']) // Jangan log jika hanya password yang berubah
            ->logOnlyDirty() // Hanya log atribut yang berubah
            ->setDescriptionForEvent(fn(string $eventName) => "Data User telah di{$eventName}")
            ->useLogName('user'); // Nama log kustom
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

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

    /**
     * Get the user's visitor profile.
     */
    public function profilPengunjung()
    {
        return $this->hasOne(ProfilPengunjung::class);
    }
}
