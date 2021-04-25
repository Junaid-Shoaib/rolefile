<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id','op_debit','op_credit','t_debit','t_credit','cl_debit','cl_credit'
    ];

    public function account()
    {
        return $this->belongsTo('App\Models\Account','account_id');
    }
}
