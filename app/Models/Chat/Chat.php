<?php

namespace App\Models\Chat;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chat\Relations\ChatRelation;
use App\Models\Chat\Scopes\ChatScope;

class Chat extends Model
{
    use HasFactory, ChatScope, ChatRelation;

    protected $fillable = [
        'chat_room_id' ,
        'user_id',
        'message'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth()->user()->id;
        });
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

}
