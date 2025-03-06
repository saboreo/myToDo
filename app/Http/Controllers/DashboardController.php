<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page.
     */
    public function index(): Response
    {
        $userId = auth()->id();

        $totalAllTasks = Task::where('user_id', $userId)->count();
        $totalInProgressTasks = Task::where('user_id', $userId)->where('status', Task::STATUS_IN_PROGRESS)->count();
        $totalHighPriorityTasks = Task::where('user_id', $userId)->where('priority', 'high')->count();

        $tasks = Task::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(5);

        return Inertia::render('Dashboard', [
            'totalAllTasks' => $totalAllTasks,
            'totalInProgressTasks' => $totalInProgressTasks,
            'totalHighPriorityTasks' => $totalHighPriorityTasks,
            'tasks' => $tasks,
            'statuses' => Task::getStatuses(),
        ]);
    }
}
