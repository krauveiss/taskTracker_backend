<?php

namespace App\Exceptions\Task;

use Exception;
use Throwable;

class TaskNotFoundException extends Exception
{
    public function __construct(string $message = "Task not found", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
