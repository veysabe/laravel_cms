<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use HasFactory;
    use AsSource;

    protected $guarded = [];

    public function banner() {
        return $this->hasOne(PostBanner::class);
    }
}
