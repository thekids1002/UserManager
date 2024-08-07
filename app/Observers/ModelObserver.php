<?php

namespace App\Observers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    /**
     * Handle the model "created" event.
     */
    public function creating(Model $model): void
    {
        $model->created_date = Carbon::now()->toDateString();
        $model->updated_date =  Carbon::now()->toDateString();
    
    }

    /**
     * Handle the model "updated" and "deleted" event.
     */
    public function updating(Model $model): void
    {
        if ($model->isDirty('deleted_date') && $model->deleted_date != NULL){
            $model->deleted_date = Carbon::now()->toDateString();
        } else {
            $model->updated_date = Carbon::now()->toDateString();
        }
    }
}
