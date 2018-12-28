<?php

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Cart\Models\Cart;

class Cart extends Model
{
    protected $table = 'carts';

    public $timestamps = false;

	public function getDateAttribute($value) {

    return \Carbon\Carbon::parse($value)->format('d-m-Y(H:i A)');
}

}
