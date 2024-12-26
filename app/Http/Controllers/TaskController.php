<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('completed', $request->status);
        }

        $tasks = $query->get();
        $categories = auth()->user()->tasks()->pluck('category')->unique();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function checkNotifications()
    {
        $tasks = auth()->user()->tasks()->whereNotNull('deadline')->get();
    
        foreach ($tasks as $task) {
            $deadline = \Carbon\Carbon::parse($task->deadline);
            $notificationTime = $deadline->subMinutes($task->notification_minutes);
    
            if (\Carbon\Carbon::now()->greaterThanOrEqualTo($notificationTime) && \Carbon\Carbon::now()->lessThan($deadline)) {
                // Kirimkan notifikasi, atau simpan ke dalam session untuk frontend
                session()->flash('notification', 'Tugas "' . $task->title . '" mendekati deadline!');
            }
        }
    
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'notification_minutes' => 'nullable|integer|min:1'
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'notification_minutes' => 'nullable|integer|min:1'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus');
    }

    public function toggleStatus(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function dashboard()
    {
        $totalTasks = auth()->user()->tasks()->count();
        $completedTasks = auth()->user()->tasks()->where('completed', true)->count();
        $pendingTasks = auth()->user()->tasks()->where('completed', false)->count();

        return view('tasks.dashboard', compact('totalTasks', 'completedTasks', 'pendingTasks'));
    }

    public function calendar()
{
    $tasks = Task::all()->map(function ($task) {
        return [
            'title' => $task->title,
            'start' => $task->deadline,
            'description' => $task->description,
        ];
    });

    return view('tasks.calendar', compact('tasks'));
}
}
