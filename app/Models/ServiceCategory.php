<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'image'
    ];

     public function services()
    {
        //satu category dapat memiliki banyak layanan
        return $this->hasMany(Service::class);
    }
}
