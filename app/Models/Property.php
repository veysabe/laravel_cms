<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $attributes = [
        'is_required' => false,
        'sort' => 100
    ];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function list_values()
    {
        return $this->hasMany(PropertyListValue::class);
    }
}
