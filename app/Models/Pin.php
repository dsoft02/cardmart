<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        /*
        |--------------------------------------------------------------------------
        | When PIN is Created
        |--------------------------------------------------------------------------
        */
        static::created(function ($pin) {

            // Only increment stock if PIN is available
            if ($pin->status === 'available' && $pin->examType) {
                $pin->examType()->increment('stock_count');
            }
        });

        /*
        |--------------------------------------------------------------------------
        | When PIN Status Changes
        |--------------------------------------------------------------------------
        */
        static::updated(function ($pin) {

            if (!$pin->wasChanged('status') || !$pin->examType) {
                return;
            }

            $originalStatus = $pin->getOriginal('status');
            $newStatus = $pin->status;

            // Available → Sold
            if ($originalStatus === 'available' && $newStatus === 'sold') {
                $pin->examType()->decrement('stock_count');
            }

            // Sold → Available (refund / reversal)
            if ($originalStatus === 'sold' && $newStatus === 'available') {
                $pin->examType()->increment('stock_count');
            }
        });

        /*
        |--------------------------------------------------------------------------
        | When PIN is Deleted
        |--------------------------------------------------------------------------
        */
        static::deleted(function ($pin) {

            if ($pin->status === 'available' && $pin->examType) {
                $pin->examType()->decrement('stock_count');
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sold_to');
    }

    public function orders()
    {
        return $this->belongsToMany(
            Order::class,
            'order_pins'
        )->withTimestamps();
    }

    public function getOrderAttribute()
    {
        return $this->orders->first();
    }

    public function getMaskedSerialAttribute()
    {
        return $this->maskValue($this->serial_number);
    }

    public function getMaskedPinAttribute()
    {
        return $this->maskValue($this->pin);
    }

    private function maskValue($value)
    {
        if (!$value || strlen($value) <= 4) {
            return $value;
        }

        $start = substr($value, 0, 3);
        $end = substr($value, -2);

        return $start . str_repeat('*', strlen($value) - 5) . $end;
    }
}
