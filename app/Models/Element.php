<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\AsSource;

class Element extends Model
{
    use HasFactory, asSource;

//    protected $fillable = [
//        'name'
//    ];

    protected $guarded = [];

    protected $attributes = [
        'sort' => 100
    ];

    public function section()
    {
        return $this->belongsToMany(Section::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

    public function banner()
    {
        return $this->hasOne(ElementBanner::class);
    }

    public function inSection($sectionId = false) {
        $query = DB::table('element_section');
        if ($sectionId) {
            $query = $query->where('section_id', $sectionId);
        }
        $ids = $query->get(['element_id'])->pluck('element_id');
        return $this->whereIn('id', $ids);
    }
}
