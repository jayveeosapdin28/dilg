<?php

namespace App\Models\Event;

use App\Models\Address\Barangay;
use App\Models\Address\City;
use App\Models\Address\Province;
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
        'country',
        'state',
        'city',
        'street',
        'barangay',
        'zip_code',
        'description',
    ];

    protected $appends = [
        'location'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->country = 'Philippines';
            $model->zip_code = '0';
        });
    }

    public function getLocationAttribute() {
        // Fetch optional province, city, and barangay descriptions
        $province = optional(Province::where('province_code', $this->state)->select('province_description')->first())->province_description;
        $city = optional(City::where('city_municipality_code', $this->city)->select('city_municipality_description')->first())->city_municipality_description;
        $barangay = optional(Barangay::where('barangay_code', $this->barangay)->select('barangay_description')->first())->barangay_description;

        // Build location string, checking for null values
        $locationParts = array_filter([
            $this->street,
            $barangay,
            $city,
            $province,
            $this->country
        ]);

        // Join parts and capitalize
        $location = implode(', ', $locationParts);
        return ucwords(strtolower($location));
    }
}
