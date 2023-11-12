<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'role',

    ];

    const ADMIN = 'admin';
    const USER = 'user';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
