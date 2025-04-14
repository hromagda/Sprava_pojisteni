<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Insurance extends Model
{
    protected $fillable = [
        'name',
    ];

    public function insuredPersons()
    {
        return $this->belongsToMany(InsuredPerson::class, 'insured_insurances', 'insurance_id', 'insured_person_id')
            ->withPivot([ 'amount', 'subject', 'valid_from', 'valid_to', 'status'])
            ->withTimestamps();
    }

    public function getValidFromAttribute($value)
    {
        return Carbon::parse($value)->format('d. m. Y');
    }

    public function getValidToAttribute($value)
    {
        return Carbon::parse($value)->format('d. m. Y');
    }

}

