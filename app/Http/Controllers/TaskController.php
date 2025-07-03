<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $tasks = Task::orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $tasks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_limite' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $task = Task::create($request->all());

        Cache::tags(['tasks'])->flush();

        return response()->json([
            'success' => true,
            'data' => $task
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        $cachedTask = Cache::tags(['tasks'])->remember("tasks.{$task->id}", 300, function () use ($task) {
            return $task;
        });

        return response()->json([
            'success' => true,
            'data' => $cachedTask
        ]);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'data_limite' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $task->update($request->all());

        Cache::tags(['tasks'])->flush();

        return response()->json([
            'success' => true,
            'data' => $task
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        Cache::tags(['tasks'])->flush();

        return response()->json([
            'success' => true,
            'message' => 'Tarefa excluída com sucesso'
        ]);
    }

    public function toggle(Task $task): JsonResponse
    {
        $task->update([
            'finalizado' => !$task->finalizado
        ]);

        Cache::tags(['tasks'])->flush();

        return response()->json([
            'success' => true,
            'data' => $task
        ]);
    }
} 