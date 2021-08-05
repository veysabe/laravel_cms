<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\asSource;

class SectionProperty extends Model
{
    use HasFactory, asSource;

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
