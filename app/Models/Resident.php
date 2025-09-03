<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Resident extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        //satu residen dapat memiliki banyak layanan
        return $this->hasMany(Service::class);
    }

    public function getAvatarUrlAttribute()
{
    if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
        return asset('storage/' . $this->avatar);
    }

    // fallback ke gambar default di public/
    return asset('assets/app/images/icons/avatar.png');
}
}
