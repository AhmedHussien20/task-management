<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\UpdateStatistics;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{


    public function index(Request $request)
    {
        $search = $request->query('search');
    
        $tasks = Task::with(['assignedTo', 'assignedBy', 'createdBy'])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%')
                             ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->paginate(10);
    
        return view('tasks.index', compact('tasks', 'search'));
    }
    

    public function create()
    {
        $admins = User::where('is_admin', true)->get();
        $users = User::where('is_admin', false)->get();
        return view('tasks.create', ['admins' => $admins, 'users' => $users]);
    }
    public function storeValidation()
    {
        return [
            'admin_name' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'assigned_user' => 'required|exists:users,id',
        ];
    }
    public function store(Request $request)
    {
        //dd($request);
        // $request->validate([
        //     'title' => 'required|max:255',
        //     'description' => 'required',
        //     'assigned_user' => 'required|exists:users,id',
        //     'admin_name' => 'required|exists:users,id',
        // ]);
        $validator = Validator::make($request->all(), $this->storeValidation());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $task = new Task();
        $task->created_by = Auth::user()->id; 
        $task->assigned_by_id = $request->input('admin_name');
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->assign_to_id = $request->input('assigned_user');
        $task->save();
        UpdateStatistics::dispatch();
        return redirect()->route('tasks.index');
    }

    public function destroy($id)
    {
        $tasks = Task::findOrFail($id);
        $tasks->delete();
        return redirect()->route('tasks.index')->with('success', 'deleted successfully');
    }

    public function statistics()
    {
      $topUsers = DB::table('users')
                ->select('users.name', DB::raw('COUNT(tasks.id) as task_count'))
                ->join('tasks', 'users.id', '=', 'tasks.assign_to_id')
                ->groupBy('users.id', 'users.name')
                ->orderByDesc('task_count')
                ->take(10)
                ->get();
        
        return view('tasks.statistics', ['topUsers' => $topUsers]);
    }

}
