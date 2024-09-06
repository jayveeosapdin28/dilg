<?php

namespace App\Models\User\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait UserScope
{
    public  function scopeOption($query){
        return $query->get(['id','name']);
    }
}
