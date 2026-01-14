<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class SocialAssistance extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'name',
        'thumbnail',
        'category',
        'amount',
        'provider',
        'description',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function socialAssistanceRecipients()
    {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }

    public function scopeSearch($query, $search)
    {
        $search = "%$search%";
        return $query->where('name', 'LIKE', $search)
                     ->orWhere('provider', 'LIKE', $search)
                     ->orWhere('amount', 'LIKE', $search);
    }
}
