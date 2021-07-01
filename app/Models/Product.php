<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =['name', 'price', 'url'];
    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    
    //definiendo mutadores para el atributo nombre
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
}
