<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','address','email','web','phone','fiscal','incorp','enabled'
    ];

    public function years()
    {
        return $this->hasMany('App\Models\Year', 'company_id');
    }

    public function settings()
    {
        return $this->hasMany('App\Models\Setting', 'company_id');
    }
}
