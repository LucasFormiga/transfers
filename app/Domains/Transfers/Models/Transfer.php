<?php

namespace App\Domains\Tranfers\Models;

use App\Domains\Users\Models\User;
use App\Traits\UuidIncrements;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    use UuidIncrements;

    protected string $keyType = 'string';

    public bool $incrementing = false;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'value',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
