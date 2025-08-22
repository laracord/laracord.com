<?php

namespace App\Tasks;

use Laracord\Tasks\Task;

class ReminderTask extends Task
{
    /**
     * The task interval.
     */
    protected int $interval = 5;

    /**
     * Determine if the task handler should execute during boot.
     */
    protected bool $eager = false;

    /**
     * Handle the task.
     */
    public function handle(): void
    {
        $this
            ->message('Hello world!')
            ->sendTo('453364472304762881');
    }
}
