<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
