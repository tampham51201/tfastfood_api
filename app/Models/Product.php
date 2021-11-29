<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $table ='products';
    protected $fillale =[
        'name',
        'category_id',
        'description',
        'qty',
        'slug',

        'img01',
        'img02',

        'orginal_price',
        'selling_price',

        'popular',
        'featured',
        'status',

    ];

    protected $with = ['category'];

    public Function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}