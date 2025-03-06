<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->task = Task::factory()->create([
        'user_id' => $this->user->id,
    ]);
});

test('task creation requires title status and priority', function () {
    $response = actingAs($this->user)->post(route('tasks.store'), [
        'title' => '',
        'description' => 'Some description',
        'status' => '',
        'priority' => '',
    ]);

    $response->assertSessionHasErrors(['title', 'status', 'priority']);
});

test('task update requires title status and priority', function () {
    $response = actingAs($this->user)->patch(
        route('tasks.update', $this->task),
        [
            'title' => '',
            'description' => 'Updated description',
            'status' => '',
            'priority' => '',
        ]
    );

    $response->assertSessionHasErrors(['title', 'status', 'priority']);
});

test('task title cannot exceed 255 characters', function () {
    $longTitle = str_repeat('o', 256);

    $response = actingAs($this->user)->post(route('tasks.store'), [
        'title' => $longTitle,
        'status' => 'todo',
        'priority' => 'medium',
    ]);

    $response->assertSessionHasErrors('title');
});

test('task status must be valid', function () {
    $response = actingAs($this->user)->post(route('tasks.store'), [
        'title' => 'Test Task',
        'status' => 'invalid_status',
        'priority' => 'medium',
    ]);

    $response->assertSessionHasErrors('status');
});

test('task priority must be valid', function () {
    $response = actingAs($this->user)->post(route('tasks.store'), [
        'title' => 'Test Task',
        'status' => 'todo',
        'priority' => 'invalid_priority',
    ]);

    $response->assertSessionHasErrors('priority');

    foreach (['low', 'medium', 'high'] as $validPriority) {
        $response = actingAs($this->user)->post(route('tasks.store'), [
            'title' => 'Test Task',
            'status' => 'todo',
            'priority' => $validPriority,
        ]);

        $response->assertSessionDoesntHaveErrors('priority');
    }
});

test('task is successfully created with valid data', function () {
    $taskData = [
        'title' => 'New Test Task',
        'description' => 'Test Description',
        'status' => 'todo',
        'priority' => 'medium',
    ];

    $response = actingAs($this->user)->post(route('tasks.store'), $taskData);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();

    $this->assertDatabaseHas('tasks', [
        'title' => 'New Test Task',
        'user_id' => $this->user->id,
    ]);
});
