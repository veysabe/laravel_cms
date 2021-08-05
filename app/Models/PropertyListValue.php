<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyListValue extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'property_id',
        'value'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
