<?php

namespace App\Models;

use App\Traits\FileHelper;
use App\Traits\HasApiWhere;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory, FileHelper, HasApiWhere;

    protected $fillable = ['name', 'tag', 'description', 'developer_id', 'logo', 'cover_photo', 'is_active'];

    public function cameras(): HasMany
    {
        return $this->hasMany(Camera::class);
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }
}
