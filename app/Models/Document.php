<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','path','enabled','year_id','is_folder', 'parent_id'
    ];

    public function year(){
        return $this->belongsTo('App\Models\Year', 'year_id');
    }

    public function approval()
    {
        return $this->hasOne('App\Models\Approval', 'document_id');
    }

}
