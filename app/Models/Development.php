<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Development extends Model
{
    use HasFactory, SoftDeletes, UUID;


    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'person_in_charge',
        'start_date',
        'end_date',
        'amount',
    ];

    public function scopeSearch($query, $search)
    {
        $search = "%$search%";
        return $query->where('name', 'LIKE', $search)
                     ->orWhere('person_in_charge', 'LIKE', $search)
                     ->orWhere('start_date', 'LIKE', $search)
                     ->orWhere('end_date', 'LIKE', $search);
    }

    public function developmentApplicants()
    {
        return $this->hasMany(DevelopmentApplicant::class);
    }
}
