<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Event extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'price',
        'date',
        'time',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

     public function scopeSearch($query, $search)
    {
        $search = "%$search%";
        return $query->where('name', 'LIKE', $search)
                     ->orWhere('date', 'LIKE', $search)
                     ->orWhere('price', 'LIKE', $search);
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
