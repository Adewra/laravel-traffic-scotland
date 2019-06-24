<?php

namespace Adewra\TrafficScotland;

use Carbon\Carbon;
use GeoJson\Geometry\Point;
use Illuminate\Database\Eloquent\Model;

class Roadwork extends Model
{
    protected $table = 'roadworks';
    protected $primaryKey = 'id';
    protected $increments = true;

    protected $fillable = [
        'identifier',
        'prefix',
        'title',
        'description',
        'link',
        'latitude',
        'longitude',
        'comments',
        'date',
        'start_date',
        'end_date',
        'week_commencing',
        'direction',
        'works',
        'traffic_management',
        'delay_information',
        'diversion_information',
        'extra_location_details',
        'affected_dates'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    protected $hidden = [
        'description',
        'latitude',
        'longitude'
    ];

    protected $appends = [
        'location'
    ];

    protected $dates = [
        'date',
        'start_date',
        'end_date'
    ];

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->toDateString();
    }

    public function getDateAttribute($value)
    {
        return $this->attributes['date'];
    }

    public function setLatitudeAttribute($value)
    {
        $this->attributes['latitude'] = $value;
    }

    public function setLongitudeAttribute($value)
    {
        $this->attributes['longitude'] = $value;
    }

    public function setLocationAttribute($value)
    {
        /*$this->attributes['latitude'] = $value[0];
        $this->attributes['longitude'] = $value[1];*/
    }

    public function getLocationAttribute()
    {
        if(isset($this->attributes['latitude']) && isset($this->attributes['longitude']))
            return new Point([$this->latitude, $this->longitude]);
        else
            return null;
    }

    private function isPlanned()
    {
        return isset($this->attributes['works']) && isset($this->attributes['traffic_management']);
    }

    private function isCurrent()
    {
        return !$this->isPlanned();
    }
}