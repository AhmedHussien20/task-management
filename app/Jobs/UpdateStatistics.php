<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\User;
class UpdateStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $topUsers = DB::table('users')
        ->select('users.id', 'users.name', DB::raw('COUNT(tasks.id) as task_count'))
        ->join('tasks', 'users.id', '=', 'tasks.assign_to_id')
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('task_count')
        ->take(10)
        ->get();
 
    }
}
