<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomBlockFields extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function block()
    {
        return $this->belongsTo(CustomBlock::class);
    }
}
