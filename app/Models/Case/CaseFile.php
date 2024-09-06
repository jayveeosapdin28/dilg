<?php

namespace App\Models\Case;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Case\Relations\CaseRelation;
use App\Models\Case\Scopes\CaseScope;

class CaseFile extends Model
{
    use HasFactory,CaseScope,CaseRelation;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'date_open',
        'date_closed',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth()->user()->id;
        });


    }
}
