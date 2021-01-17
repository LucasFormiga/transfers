<?php

namespace App\Domains\Users\Models;

use App\Domains\Transfers\Models\Transfer;
use App\Traits\UuidIncrements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use UuidIncrements;

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

        static::restored(fn ($model) => $model->wallet->restore());

        static::deleting(fn ($model) => $model->wallet->delete());
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function payer(): HasMany
    {
        return $this->hasMany(Transfer::class, 'payer', 'id');
    }

    public function payee(): HasMany
    {
        return $this->hasMany(Transfer::class, 'payee', 'id');
    }

    public function canTransfer(): bool
    {
        return $this->document_type != self::DOC_TYPE_CNPJ;
    }
}
