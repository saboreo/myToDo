<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->owner = User::factory()->create();
    $this->anotherUser = User::factory()->create();

    $this->task = Task::factory()->create([
        'user_id' => $this->owner->id,
        'title' => 'First title',
        'status' => 'todo',
        'priority' => 'medium',
    ]);
});

test('user can only edit own task', function () {
    $updateData = [
        'title' => 'Changed Title',
        'status' => 'in progress',
        'priority' => 'high',
    ];

    $response = actingAs($this->anotherUser)->patch(route('tasks.update', $this->task), $updateData);
    $response->assertForbidden()->assertStatus(403);
    expect($this->task->fresh()->title)->toBe('First title');

    $response = actingAs($this->owner)->patch(route('tasks.update', $this->task), $updateData);
    $response->assertRedirect()->assertStatus(302);

    expect($this->task->fresh())
        ->title->toBe('Changed Title')
        ->status->toBe('in progress')
        ->priority->toBe('high');
});

test('user can\'t delete another user\'s task', function () {
    $response = actingAs($this->anotherUser)->delete(route('tasks.destroy', $this->task));
    $response->assertForbidden()->assertStatus(403);
    expect(Task::find($this->task->id))->not->toBeNull();

    $response = actingAs($this->owner)->delete(route('tasks.destroy', $this->task));
    $response->assertRedirect()->assertStatus(302);
    expect(Task::find($this->task->id))->toBeNull();
});
