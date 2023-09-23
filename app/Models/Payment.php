<?php

namespace App\Models;

use App\Casts\PaymentCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(array $array, array $array1)
 */
class Payment extends Model
{
    public const FAILED = 0;
    public const SUCCESS = 1;
    public const PENDING = 2;

    protected $fillable = [
        'user_id',
        'payment_amount',
        'payment_status'
    ];

    protected $casts = [
        'payment_status' => PaymentCast::class
    ];
}
