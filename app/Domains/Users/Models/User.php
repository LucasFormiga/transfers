<?php

namespace App\Domains\Users\Models;

use App\Domains\Tranfers\Models\Transfer;
use App\Traits\UuidIncrements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use UuidIncrements;
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public const DOC_TYPE_CPF = 'cpf';
    public const DOC_TYPE_CNPJ = 'cnpj';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'document',
        'document_type',
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

    public static function boot()
    {
        parent::boot();

        static::created(fn ($model) => $model->wallet()->create([
            'user_id' => $model->id,
        ]));
    }

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

    public function canTransfer()
    {
        return $this->document_type != self::DOC_TYPE_CNPJ;
    }
}
