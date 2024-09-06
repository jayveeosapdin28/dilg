<?php

namespace App\Models\Rank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rank\Relations\RankRelation;
use App\Models\Rank\Scopes\RankScope;

class Rank extends Model
{
    use HasFactory,RankScope,RankRelation;
}
