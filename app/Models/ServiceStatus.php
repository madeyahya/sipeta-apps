<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceStatus extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'service_id',
        'image',
        'status',
        'description'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
