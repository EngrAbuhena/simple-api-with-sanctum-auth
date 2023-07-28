<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    // mass assignment
    public mixed $name;
    public mixed $price;
    public mixed $description;
    protected $fillable = [
        'name', 'price', 'description'
    ];
    
}
