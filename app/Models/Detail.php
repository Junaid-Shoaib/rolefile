<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'voucher','particular','amount','cols','account_id'
    ];

    protected $casts = [
        'cols' => 'array'
    ];

}
