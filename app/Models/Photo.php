<?php

namespace App\Models;

use App\Traits\FileHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Photo extends Model
{
    use HasFactory, FileHelper;

    protected $appends = ['path', 'captured_at'];

    protected $fillable = ['image', 'created_at', 'updated_at'];

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getImagePath('image'),
        );
    }

    protected function capturedAt(): Attribute
    {
        $timezone = $this->camera->timezone ?? 'Asia/Dubai';

        return Attribute::make(
            get: fn () => $this->created_at?->clone()->setTimezone($timezone)->format('H:i'),
        );
    }

    public function camera(): BelongsTo
    {
        return $this->belongsTo(Camera::class);
    }

    public function scopeWhereRangeIn(Builder $query, Carbon $startDate, Carbon $endDate)
    {
        $startDate = $startDate->setTimezone('UTC')->startOfDay();
        $endDate = $endDate->setTimezone('UTC')->endOfDay();

        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeWhereDateIn(Builder $query, Carbon $date)
    {
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();

        $startOfDayUTC = $startOfDay->setTimezone('UTC');
        $endOfDayUTC = $endOfDay->setTimezone('UTC');

        return $query->whereBetween('created_at', [$startOfDayUTC, $endOfDayUTC]);
    }
    
}
