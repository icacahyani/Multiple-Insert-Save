<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    //
    protected $fillable = ['cus_id', 'pro_id', 'qty', 'price', 'dis', 'amount'];
}
