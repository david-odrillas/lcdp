<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'url'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    //definiendo mutadores para el atributo nombre
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
}
