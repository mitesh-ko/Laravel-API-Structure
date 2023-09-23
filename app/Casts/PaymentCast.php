<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PaymentCast implements CastsAttributes
{
    private $parseData = [
        'id' => [
            'failed' => 0,
            'success' => 1,
            'pending' => 2
        ],
        'text' => [
             0 => 'Failed',
             1 => 'Success',
             2 => 'Pending'
        ]
    ];
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $this->parseData['text'][$value];
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $this->parseData['id'][$value];
    }
}
