<?php

namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait UuidIncrements
{
    /**
     * Boot function.
     */
    public static function bootUuidIncrements(): void
    {
        static::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
}
