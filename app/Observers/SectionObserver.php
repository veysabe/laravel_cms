<?php

namespace App\Observers;

use App\Models\Section;
use Illuminate\Support\Facades\DB;

class SectionObserver
{
    /**
     * Handle the Section "created" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function created(Section $section)
    {
        $section->social()->create();
        $section->fields()->create();
    }

    /**
     * Handle the Section "updated" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function updated(Section $section)
    {
        //
    }

    /**
     * Handle the Section "deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function deleted(Section $section)
    {

        DB::table('section_in_section_pivot')
            ->where('section_id', $section->id)
            ->orWhere('parent_section_id', $section->id)
            ->delete();

        DB::table('section_property')
            ->where('section_id', $section->id)
            ->delete();
    }

    /**
     * Handle the Section "restored" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function restored(Section $section)
    {
        //
    }

    /**
     * Handle the Section "force deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function forceDeleted(Section $section)
    {
        //
    }
}
