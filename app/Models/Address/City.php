<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'philippine_cities';

    public function scopeOptions($query,$province_code)
    {
        return $query->select(['city_municipality_code', 'city_municipality_description'])
            ->where('province_code',$province_code)
            ->orderBy('city_municipality_description')
            ->get()->map(function ($data){
            return [
                'value' =>  $data->city_municipality_code,
                'label' => $data->city_municipality_description,
            ];
        });
    }
}
