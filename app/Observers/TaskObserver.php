<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\Project;

class TaskObserver
{

    public function created(Task $task)
    {
        $task->project->recordActivity('created_task');
    }

    public function deleted(Task $task)
    {
        $task->project->recordActivity('deleted_task');
    }
    /**
     * Handle the Task "updated" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }


    /**
     * Handle the Task "restored" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
