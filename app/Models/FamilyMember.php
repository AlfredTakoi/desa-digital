<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class FamilyMember extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'head_of_family_id',
        'user_id',
        'profile_picture',
        'gender',
        'date_of_birth',
        'phone_number',
        'identity_number',
        'occupation',
        'relation',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('user', function($query) use ($search){
            $query->where('name','LIKE','%'. $search .'%')
            ->orWhere('email','LIKE','%'. $search .'%');
        })->orWhere('phone_number','LIKE','%'. $search .'%')
        ->orWhere('identity_number','LIKE','%'. $search .'%')
        ->orWhere('occupation','LIKE','%'. $search .'%')
        ->orWhere('relation','LIKE','%'. $search .'%');
    }

    public function headOfFamily() {
        return $this->belongsTo(HeadOfFamily::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
