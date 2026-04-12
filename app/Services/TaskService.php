<?php

namespace App\Services;

use App\Exceptions\Task\TaskNotFoundException;
use App\Models\Task;

class TaskService
{
    public function createTask($title, $done): Task
    {
        if (!$done) {
            $done = false;
        }

        $task = Task::create([
            'title' => $title,
            'done' => $done
        ]);
        return $task;
    }

    public function updateTask($title, $done, $task_id): Task
    {
        if (!$done) {
            $done = false;
        }
        $task = Task::find($task_id);
        if (!$task) {
            throw new TaskNotFoundException();
        }
        $task->update(
            [
                'title' => $title,
                'done' => $done
            ]
        );
        $task->save();
        return $task;
    }

    public function deleteTask($task_id): void
    {
        $task = Task::find($task_id);
        if (!$task) {
            throw new TaskNotFoundException();
        }
        $task->delete();
    }

    public function toggleTask($task_id): void
    {

        $task = Task::find($task_id);
        if (!$task) {
            throw new TaskNotFoundException();
        }
        $task->done = $task->done ? false : true;
        $task->save();
    }
}
