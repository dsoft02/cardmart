<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ExamType extends Model
{
    protected $guarded = [];

    public function pins()
    {
        return $this->hasMany(Pin::class);
    }

    public function getAvailableStockAttribute()
    {
        return $this->pins()
            ->where('status', 'available')
            ->count();
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image && Storage::disk('public')->exists($this->cover_image)) {
            return asset('storage/' . $this->cover_image);
        }

        return asset('assets/img/placeholders/exam-cover.png');
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && Storage::disk('public')->exists($this->logo)) {
            return asset('storage/' . $this->logo);
        }

        return asset('assets/img/placeholders/exam-logo.png');
    }

    public function getCardbgUrlAttribute(): string
    {
        if ($this->pin_background_image && Storage::disk('public')->exists($this->pin_background_image)) {
            return asset('storage/' . $this->pin_background_image);
        }

        return asset('assets/img/placeholders/exam-bg.png');
    }
}
