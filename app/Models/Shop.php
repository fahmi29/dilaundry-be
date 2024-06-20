<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public function laundries() 
    {
        return $this->hasMany(Laundry::class);
    }

    protected $table = 'shops';
    protected $fillable = [
        'image',
        'name',
        'location',
        'city',
        'delivery',
        'pickup',
        'whatsapp',
        'descriptionn',
        'price',
        'rate'
    ];
}
