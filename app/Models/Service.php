<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'resident_id',
        'service_category_id',
        'title',
        'description',
        'image',
    ];

     public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function serviceStatuses()
    {
        return $this->hasMany(ServiceStatus::class);
    }

    // Tambahkan relasi ini untuk ambil status terakhir
    public function latestStatus()
    {
        return $this->hasOne(ServiceStatus::class)->latestOfMany();
        // atau: return $this->hasOne(ServiceStatus::class)->orderByDesc('id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
