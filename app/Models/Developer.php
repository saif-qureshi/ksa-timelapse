<?php

namespace App\Models;

use App\Traits\FileHelper;
use App\Traits\HasApiWhere;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Developer extends Model
{
    use HasFactory, FileHelper, HasApiWhere;

    protected $fillable = ['name', 'description', 'tag', 'is_active', 'logo', 'cover_photo'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
