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

    public function social()
    {
        return $this->hasOne(Social::class, 'section_id');
    }

    public function fields()
    {
        return $this->hasOne(SectionFields::class);
    }

    public function depth()
    {
        $id = $this->id;
        $query = DB::table('section_in_section_pivot');
        if ($id) {
            $query = $query
                ->where('parent_section_id', $id)
                ->where('section_id', '!=', $id);
        }
        $ids = $query->get(['section_id'])->pluck('section_id');
        return $id ? $this->whereIn('id', $ids) : $this->whereNotIn('id', $ids);
    }

    public function reverseDepth()
    {
        $id = $this->id;
        $ids = [];
        $query = DB::table('section_in_section_pivot')->get();
        $children = $query->pluck('section_id')->toArray();
        $parents = $query->pluck('parent_section_id')->toArray();
        $tree = Arrays::makeParentChildrenTree($parents, $children);
        $tree = isset($tree[$id]) ? $tree[$id] : [];
        Arrays::getIds($tree, $ids);
        return $id ? $this->whereNotIn('id', $ids)->where('id', '!=', $id) : $this->whereIn('id', $ids)->where('id', '!=', $id);
    }

    public function getParents() {
        $id = $this->id;
        $ids = [];
        $query = DB::table('section_in_section_pivot')->get();
        $children = $query->pluck('section_id')->toArray();
        $parents = $query->pluck('parent_section_id')->toArray();
        $tree = Arrays::makeParentChildrenTree($parents, $children);
        Arrays::getParentIds($tree, $id, $ids);
        return Section::whereIn('id', $ids);
    }
}
