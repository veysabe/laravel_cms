<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementInSectionProperties extends Model
{
    use HasFactory;

    public function elements()
    {
        return $this->belongsToMany(Element::class, 'element_in_section_properties');
    }
}
