<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(string[] $array)
 * @method static where(string $string, int|string|null $id)
 * @method static updateOrCreate(array $array, array $array1)
 */
class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'total'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
