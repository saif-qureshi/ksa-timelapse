<?php

namespace App\Models;

use App\Traits\FileHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory, FileHelper;

    protected $appends = ['path'];

    protected $fillable = ['image'];

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getImagePath('image'),
        );
    }
}
