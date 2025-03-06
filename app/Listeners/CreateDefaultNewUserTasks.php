<?php

namespace App\Listeners;

use App\Models\Task;
use Illuminate\Auth\Events\Registered;

class CreateDefaultNewUserTasks
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Create default tasks for the newly registered user.
     */
    public function handle(Registered $event): void
    {
        Task::factory()->count(8)->create([
            'user_id' => $event->user->id,
        ]);
    }
}
