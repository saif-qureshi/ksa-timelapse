<?php

namespace App\Models;

use App\Traits\FileHelper;
use App\Traits\HasApiWhere;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Developer extends Model
{
    use HasFactory, FileHelper, HasApiWhere;

    protected $fillable = ['name', 'description', 'tag', 'is_active', 'logo', 'cover_photo'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'access_user_developer');
    }

    public function scopeFilterByRole($query, $user)
    {
        return $query->when(in_array($user->role, ['admin','project_admin', 'customer']), function ($query) use ($user) {
            return $query->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        })->when(in_array($user->role, ['super_admin']), function ($query) {
            return $query;
        });
    }
}
