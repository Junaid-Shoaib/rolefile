<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id','status'
    ];

    protected $casts = [
        'status' => 'array'
    ];

    public function document(){
        return $this->belongsTo('App\Models\Document', 'document_id');
    }
}
