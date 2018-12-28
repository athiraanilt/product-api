<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Product\Models\Product;

class Product extends Model
{
    protected $table = 'products';

    public $timestamps = false;

}
