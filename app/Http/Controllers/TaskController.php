<?php

namespace App\Http\Controllers;

use App\Exceptions\Task\TaskNotFoundException;
use App\Exceptions\Task\TasksListIsEmptyException;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Exception;

class TaskController extends Controller
{
    public function __construct(protected TaskService $task_service) {}

    public function index()
    {
        try {
            $tasks = Task::all();
            if ($tasks->isEmpty()) {
                throw new TasksListIsEmptyException();
            }

            return TaskResource::collection($tasks);
        } catch (TasksListIsEmptyException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (Exception) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    public function store(CreateTaskRequest $request)
    {
        try {
            $task = $this->task_service->createTask($request->title, $request->done);
            return response()->json(['data' => new TaskResource($task)], 201);
        } catch (Exception) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }


    public function update(CreateTaskRequest $request, int $id)
    {
        try {
            $task = $this->task_service->updateTask($request->title, $request->done, $id);
            return response()->json(['data' => new TaskResource($task)], 200);
        } catch (TaskNotFoundException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (Exception) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->task_service->deleteTask($id);
            return response()->json(['message' => 'Success'], 200);
        } catch (TaskNotFoundException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (Exception) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $task = Task::find($id);
            if (!$task) {
                throw new TaskNotFoundException();
            }
            return response()->json(['data' => new TaskResource($task)], 200);
        } catch (TaskNotFoundException $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (Exception) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }
}
