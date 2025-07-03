<?php

namespace App\Observers;

use App\Models\Task;
use App\Jobs\DeleteCompletedTask;
use Illuminate\Support\Facades\Cache;

class TaskObserver
{
    public function updated(Task $task): void
    {
        if ($task->wasChanged('finalizado') && $task->finalizado) {
            DeleteCompletedTask::dispatch($task->id)
                ->delay(now()->addMinutes(10));
        }
    }

    public function deleted(Task $task): void
    {
        Cache::tags(['tasks'])->flush();
    }

    public function created(Task $task): void
    {
        Cache::tags(['tasks'])->flush();
    }
}