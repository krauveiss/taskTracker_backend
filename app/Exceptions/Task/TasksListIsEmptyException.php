<?php

namespace App\Exceptions\Task;

use Exception;
use Throwable;

class TasksListIsEmptyException extends Exception
{
    public function __construct(string $message = "Tasks list is empty", int $code = 404, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
