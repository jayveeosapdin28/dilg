<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TaskDocument extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = ['task_id','user_id','score'];
    protected $appends = ['file_url','file'];

    protected $hidden = ['media'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth()->user()->id;
        });


    }

    public function getFileUrlAttribute()
    {
        $media = $this->getFirstMedia('files');

        if ($media) {
            return $media->getUrl();
        }

        return null;
    }
    public function getFileAttribute()
    {
        $media = $this->getFirstMedia('files');

        if ($media) {
            return [
                'url' => $media->getUrl(),
                'name' => $media->name,
                'file_name' => $media->file_name,
                'mime_type' => $media->mime_type,
            ];
        }

        return null;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
