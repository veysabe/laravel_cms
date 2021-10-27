<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementBanner extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }
}
