<?php

namespace App\Models\User\Relations;

trait UserRelation
{
    public function getRoleAttribute(): string
    {
        return $this->getRoleNames()->implode(', ');
    }
}
