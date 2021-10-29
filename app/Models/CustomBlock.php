<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomBlock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fields()
    {
        return $this->hasOne(CustomBlockFields::class);
    }

    public function properties()
    {
        return $this->hasMany(CustomBlockProperty::class);
    }
}
