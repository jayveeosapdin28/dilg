<?php

namespace App\Models\Document;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document\Relations\DocumentRelation;
use App\Models\Document\Scopes\DocumentScope;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use HasFactory,DocumentScope,DocumentRelation;
    use InteractsWithMedia;

    protected $fillable = ['name','category','description','user_id'];

    protected $appends = ['file_url'];


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

    public function user(){
        return $this->belongsTo(User::class);
    }
}
