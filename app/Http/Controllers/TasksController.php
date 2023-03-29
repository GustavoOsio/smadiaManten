<?php

namespace App\Http\Controllers;


use App\Models\Campaign;
use App\Models\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('view', Task::class);
        $taskAll = Task::all();
        $dateToday= date("Y-m-d");
        foreach ($taskAll as $t){
            if($t->date < $dateToday){
                $t_update = Task::find($t->id);
                if($t_update->status == 'activa'){
                    $t_update->status = 'vencida';
                    $t_update->save();
                }
            }
        }
        $validate = User::find(Auth::id());
        if ($validate->role->superadmin == 1) {
            $task = Task::orderBy('id','desc')->get();
            $val = 1;
        }else{
            $task = Task::orderBy('id','desc')->where('user_id',Auth::id())->get();
            $val = 2;
        }
        return view('task.index', [
            'task' => $task,
            'val' => $val
        ]);
    }

    public function edit(Task $task)
    {
        $this->authorize('update', Task::class);
        return view('task.edit',['task' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', Task::class);
        request()->validate([
            'title' => 'required|string|max:255',
            'comment' => 'required',
            'status' => 'required|alpha|max:25',
        ]);
        $task->update([
            'title' => $request->title,
            'comment' => $request->comment,
            'date' => $request->date,
            'status' => $request->status,
        ]);
        return redirect()->route('tasks.index')
            ->with('success','Tarea actualizada exitosamente.');
    }

    public function delete($id)
    {
        $this->authorize('delete', Task::class);
        $campaign = Task::find($id);
        $campaign->delete();
        return redirect()->route('tasks.index')
                ->with('success','Tarea eliminada exitosamente');
    }

}
