<?php

namespace App\Models;

use App\Models\Chat\Chat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'name', 'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->user_id = auth()->user()->id;
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_chat_room', 'chat_room_id', 'user_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'chat_room_id');
    }

    public function getNameAttribute()
    {
        $users = UserChatRoom::query()
            ->where('chat_room_id', $this->id)
            ->where('user_id', '!=', auth()->user()->id)
            ->first();

        return User::find($users->user_id)->name;
    }
}
