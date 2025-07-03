<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DeleteCompletedTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 60;
    public $tries = 3;

    public function __construct(
        private int $taskId
    ) {}

    public function handle(): void
    {
        $task = Task::withTrashed()->find($this->taskId);
        
        if (!$task) {
            return;
        }

        if (!$task->finalizado) {
            return;
        }

        $task->forceDelete();
        
        Cache::tags(['tasks'])->flush();  // ✅ Sem backslash
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Falha ao excluir tarefa finalizada', [  // ✅ Sem backslash
            'task_id' => $this->taskId,
            'error' => $exception->getMessage()
        ]);
    }
}