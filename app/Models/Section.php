<?php

namespace App\Models;

use App\Helpers\Arrays;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\AsSource;

class Section extends Model
{
    use HasFactory, asSource;

    protected $guarded = [];

    protected $attributes = [
        'sort' => 100
    ];

    public function elements()
    {
        return $this->belongsToMany(Element::class);
    }

    public function properties()
    {
        return $this->belongsToMany(SectionProperty::class, 'section_property', 'section_id', 'property_id');
    }

    public function section()
    {
        return $this->belongsToMany(Section::class, 'section_in_section_pivot', 'section_id', 'parent_section_id');
    }

    public function main_section()
    {
        return $this->belongsToMany(Section::class, 'main_section_pivot', 'section_id', 'parent_section_id');
    }

    public function social()
    {
        return $this->hasOne(Social::class, 'section_id');
    }

    public function fields()
    {
        return $this->hasOne(SectionFields::class);
    }

    public function menu()
    {
        return $this->hasOne(Menu::class);
    }
}
