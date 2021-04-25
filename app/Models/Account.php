<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'number','name','group_id'
    ];

    public function group(){
        return $this->belongsTo('App\Models\Group', 'group_id');
    }

    public function balance()
    {
        return $this->hasOne('App\Models\Balance', 'account_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\Detail','account_id');
    }

}
