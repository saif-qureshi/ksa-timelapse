<?php

namespace App\Models;

use App\Traits\FileHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory, FileHelper;

    protected $appends = ['path', 'name'];

    protected $fillable = ['user_id', 'camera_id', 'status', 'file', 'start_date', 'end_date', 'generated_at'];

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getImagePath('file'),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::replace('videos/', '', $this->file),
        );
    }
}
