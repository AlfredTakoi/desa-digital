<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class HeadOfFamily extends Model
{
    use HasFactory, softDeletes, UUID;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'gender',
        'date_of_birth',
        'identity_number',
        'phone_number',
        'occupation',
        'marital_status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('user', function($query) use ($search){
            $query->where('name','LIKE','%'. $search .'%')
            ->orWhere('email','LIKE','%'. $search .'%');
        })->orWhere('phone_number','LIKE','%'. $search .'%')
        ->orWhere('identity_number','LIKE','%'. $search .'%')
        ->orWhere('occupation','LIKE','%'. $search .'%')
        ->orWhere('marital_status','LIKE','%'. $search .'%');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyMembers() {
        return $this->hasMany(FamilyMember::class);
    }

    public function socialAssistanceRecipients()
    {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
