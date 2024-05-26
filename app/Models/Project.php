<?php

namespace App\Models;

use App\Traits\FileHelper;
use App\Traits\HasApiWhere;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'access_user_project');
    }

    public function scopeFilterByRole($query, $user)
    {
        return $query->when(in_array($user->role, ['project_admin', 'customer']), function ($query) use ($user) {
            return $query->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        })->when(in_array($user->role, ['super_admin', 'admin']), function ($query) {
            return $query;
        });
    }
}
