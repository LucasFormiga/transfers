<?php

namespace App\Domains\Users\Models;

use App\Domains\Tranfers\Models\Transfer;
use App\Traits\UuidIncrements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use UuidIncrements;

    protected string $keyType = 'string';

    public bool $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'document',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function sentTransfers()
    {
        return $this->hasMany(Transfer::class, 'sender_id', 'id');
    }

    public function receivedTransfers()
    {
        return $this->hasMany(Transfer::class, 'receiver_id', 'id');
    }
}
