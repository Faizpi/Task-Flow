<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NotifyUpcomingTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-upcoming-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('deadline', '>=', now())
                 ->where('deadline', '<=', now()->addDay())
                 ->where('completed', false)
                 ->get();

    foreach ($tasks as $task) {
        $user = $task->user;
        \Mail::raw(
            "Halo, {$user->name}. Jangan lupa tugas '{$task->title}' akan segera deadline pada {$task->deadline}.",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Pengingat Tugas Mendekati Deadline');
            }
        );
    }

    $this->info('Notifikasi berhasil dikirim!');
    }
}
