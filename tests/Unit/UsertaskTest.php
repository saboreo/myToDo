<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('task belongs to a user', function () {
    $user = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Task',
        'status' => 'todo',
        'priority' => 'medium',
    ]);

    expect($task->user)
        ->toBeInstanceOf(User::class)
        ->and($task->user->id)
        ->toBe($user->id);
});
