<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Set up project repository',
            'Review and merge pull requests',
            'Write documentation for new features',
            'Fix user authentication issue',
            'Prepare for client meeting',
            'Update UI based on feedback',
            'Test new authentication flow',
            'Ensure unit tests pass before release',
        ];

        $descriptions = [
            'Review the pull requests, check for issues, and merge them into the main branch.',
            'Fix the bug in the user registration process that is causing authentication failures. Investigate the code thoroughly, run tests, and ensure that the issue is resolved before deploying the changes to production.',
            'Ensure all unit tests pass and address any issues before the release.',
            'Prepare a presentation for the client meeting tomorrow.',
            'Test the new authentication flow in staging environment.',
            'Prepare a presentation for the upcoming client meeting, summarizing the work done so far, future plans, and any potential roadblocks. Make sure the slides are clear and concise, with visuals that help communicate key points.',
            'Update the user interface based on the latest feedback to improve usability.',
            'Set up the project repository with the necessary configurations and dependencies.',
        ];

        return [
            'title' => $this->faker->unique()->randomElement($titles),
            'description' => $this->faker->unique()->randomElement($descriptions),
            'status' => $this->faker->randomElement(Task::getStatuses()),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
        ];
    }
}
