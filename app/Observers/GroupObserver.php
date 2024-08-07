<?php

namespace App\Observers;

use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

class GroupObserver
{
    /**
     * Handle the Group "created" event.
     */
    public function creating(Group $group): void
    {
        $group->created_date = Carbon::now()->toDateString();
        $group->updated_date =  Carbon::now()->toDateString();
    }

    /**
     * Handle the Group "updated" event.
     */
    public function updating(Group $group): void
    {
        if ($group->isDirty('deleted_date') && $group->deleted_date != NULL){
            $group->deleted_date = Carbon::now()->toDateString();
        }
    }
}
