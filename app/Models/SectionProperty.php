<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\asSource;

class SectionProperty extends Model
{
    use HasFactory, asSource;

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function list_values()
    {
        return $this->hasMany(SectionPropertyListValues::class, 'property_id');
    }
}
