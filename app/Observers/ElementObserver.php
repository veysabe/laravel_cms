<?php

namespace App\Observers;

use App\Models\Element;
use Illuminate\Support\Facades\DB;

class ElementObserver
{
    /**
     * Handle the Element "created" event.
     *
     * @param  \App\Models\Element  $element
     * @return void
     */
    public function created(Element $element)
    {
        //
    }

    /**
     * Handle the Element "updated" event.
     *
     * @param  \App\Models\Element  $element
     * @return void
     */
    public function updated(Element $element)
    {
        //
    }

    /**
     * Handle the Element "deleted" event.
     *
     * @param  \App\Models\Element  $element
     * @return void
     */
    public function deleted(Element $element)
    {
        DB::table('element_property')->where('element_id', $element->id)->delete();
        $element->banner()->delete();
    }

    /**
     * Handle the Element "restored" event.
     *
     * @param  \App\Models\Element  $element
     * @return void
     */
    public function restored(Element $element)
    {
        //
    }

    /**
     * Handle the Element "force deleted" event.
     *
     * @param  \App\Models\Element  $element
     * @return void
     */
    public function forceDeleted(Element $element)
    {
        //
    }
}
