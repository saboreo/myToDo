<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('newly registered user gets default tasks', function () {
    $user = User::factory()->create();
    event(new Registered($user));

    assertDatabaseCount('tasks', 8);

    $taskTitles = [
        'Set up project repository',
        'Review and merge pull requests',
        'Write documentation for new features',
        'Fix user authentication issue',
        'Prepare for client meeting',
        'Update UI based on feedback',
        'Test new authentication flow',
        'Ensure unit tests pass before release',
    ];

    foreach ($taskTitles as $title) {
        assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => $title,
        ]);
    }
});

test('new user receives 8 tasks upon registration', function () {
    $user = User::factory()->create();

    event(new Registered($user));

    $this->assertDatabaseCount('tasks', 8);
});
