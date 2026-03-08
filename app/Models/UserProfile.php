<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'phone_number',
        'address',
        'identity_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'join_date',
        'resign_date',
        'photo_path',
    ];

    protected function casts(): array
    {
        return [
            'join_date' => 'date',
            'resign_date' => 'date',
        ];
    }

    /**
     * Profil ini milik satu User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}