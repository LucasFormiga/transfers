<?php

namespace App\Domains\Transactions\Models;

use App\Domains\Transactions\Observers\TransactionObserver;
use App\Domains\Users\Models\User;
use App\Traits\Observable;
use App\Traits\UuidIncrements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use Observable;
    use SoftDeletes;
    use UuidIncrements;

    protected $keyType = 'string';
    public $incrementing = false;

    public static string $observer = TransactionObserver::class;

    protected $fillable = [
        'payer',
        'payee',
        'value',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer', 'id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payee', 'id');
    }
}
