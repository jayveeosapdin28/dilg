<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $table = 'philippine_barangays';

    public function scopeOptions($query,$city_municipality_code)
    {
        return $query->select(['barangay_code', 'barangay_description'])
            ->where('city_municipality_code',$city_municipality_code)
            ->orderBy('barangay_description')
            ->get()->map(function ($data){
            return [
                'value' => $data->barangay_code,
                'label' => $data->barangay_description,
            ];
        });
    }
}
