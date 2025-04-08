<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuredPerson extends Model
{

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone',
        'street',
        'city',
        'zip_code',
        'photo',
    ];

    public function insurances()
    {
        return $this->belongsToMany(Insurance::class, 'insured_insurances', 'insured_person_id', 'insurance_id')
            ->withPivot([ 'amount', 'subject', 'valid_from', 'valid_to'])
            ->withTimestamps();
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
