<?php

namespace App\Models;

use App\Traits\FileHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function camera(): BelongsTo
    {
        return $this->belongsTo(Camera::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByRole($query, $user)
    {
        return $query->when(in_array($user->role, ['admin', 'project_admin', 'customer']), function ($query) use ($user) {
            return $query->whereHas('camera.project.users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        })->when(in_array($user->role, ['super_admin']), function ($query) {
            return $query;
        });
    }
}
