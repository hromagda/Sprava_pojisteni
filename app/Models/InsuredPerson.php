<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuredPerson extends Model
{

    use HasFactory;

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

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function insurances()
    {
        return $this->belongsToMany(Insurance::class, 'insured_insurances', 'insured_person_id', 'insurance_id')
            ->withPivot([ 'amount', 'subject', 'valid_from', 'valid_to', 'status'])
            ->withTimestamps();
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
