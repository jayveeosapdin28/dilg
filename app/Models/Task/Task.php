<?php

namespace App\Models\Task;

use App\Events\NotificationEvent;
use App\Events\SentMessageEvent;
use App\Models\Notification;
use App\Models\TaskDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task\Relations\TaskRelation;
use App\Models\Task\Scopes\TaskScope;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory, TaskScope, TaskRelation;

    protected $fillable = [
        'name',
        'description',
        'due_date',
        'user_id',
        'priority',
        'status',
        'comments',
        'users',
    ];

    protected $casts = [
        'users' => 'array'
    ];

    protected $appends = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            foreach ($model->users as $user_id) {
                $notif = Notification::create([
                    'user_id' => $user_id,
                    'title' => 'New Task Created',
                    'message' => "<b>".$model->name."</b> was added on your task list",
                    'meta' => [
                        'link' => '/admin/tasks/'.$model->id
                    ],
                ]);
                broadcast(new NotificationEvent($notif));
            }
        });
    }

    public function documents()
    {
        return $this->hasMany(TaskDocument::class, 'task_id');
    }

    public function submitted()
    {
        return $this->documents()->where('user_id', auth()->user()->id);
    }

    public function getStatusAttribute()
    {
        return $this->documents()->where('user_id', auth()->user()->id)->exists() ? 'complete' : 'pending';
    }
}
