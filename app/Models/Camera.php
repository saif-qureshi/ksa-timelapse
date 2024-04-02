<?php

namespace App\Models;

use App\Traits\FileHelper;
use App\Traits\HasApiWhere;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Camera extends Model
{
    use HasFactory, HasApiWhere, FileHelper;

    public static function boot() {
        parent::boot();
    
        static::creating(function (Camera $item) {
            $item->access_token = (new self)->getAccessToken(); 
        });

    }

    protected $fillable = [
        'index', 'name', 'description', 'longitude', 'latitude', 'developer_id', 'project_id',
        'is_active', 'video_template_1', 'video_template_2', 'access_token'
    ];

    protected $hidden = ['access_token'];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function refreshAccessToken()
    {
        $this->access_token = $this->getAccessToken();

        $this->save();
    }

    public function getAccessToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 50; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
