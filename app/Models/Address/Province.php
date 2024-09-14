<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'philippine_provinces';

    public function scopeOptions($query)
    {
        return $query->select(['province_code', 'province_description'])
            ->orderBy('province_description')
            ->get()->map(function ($data){
            return [
                'value' =>  $data->province_code,
                'label' => $data->province_description,
            ];
        });
    }
}
