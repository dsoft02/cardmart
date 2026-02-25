<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'quantity' => 'integer',
        'amount' => 'decimal:2',
        'status' => 'string',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    public function orderPins()
    {
        return $this->hasMany(OrderPin::class);
    }

    public function pins()
    {
        return $this->belongsToMany(
            Pin::class,
            'order_pins'
        )->withTimestamps();
    }

    protected function formattedAmount(): Attribute
    {
        return Attribute::get(
            fn() => number_format($this->amount, 2)
        );
    }

    public static function generateReference(): string
    {
        do {
            $prefix = 'EPST';
            $timestamp = now()->format('YmdHis');
            $random = random_int(1000, 9999);
            $reference = $prefix . $timestamp . $random;
        } while (self::where('reference', $reference)->exists());

        return $reference;
    }
}
