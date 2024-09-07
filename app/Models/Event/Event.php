<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event\Relations\EventRelation;
use App\Models\Event\Scopes\EventScope;

class Event extends Model
{
    use HasFactory,EventScope,EventRelation;

    protected $fillable = [
        'event_name',
        'date_open',
        'date_close',
        'country_id',
        'state_id',
        'city_id',
        'description',
    ];
}
