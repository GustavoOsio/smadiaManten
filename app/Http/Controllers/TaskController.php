<?php

namespace App\Http\Controllers;

use App\Helpers\SendSms;
use App\Models\Notification;
use App\Models\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'date' => 'required|date',
            'title' => 'required|string|min:3|max:80',
            'comment' => 'required|string|min:10',
            'users' => 'required',
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'date' => $request->date,
            'comment' => $request->comment
        ]);

        $task->users()->attach($request->users);

        $text = "El usuario " . $task->user->name . " le ha asignado la tarea " . $task->title . " para el día " .
            date("d/m/Y", strtotime($task->date));

        $cellphone = [];
        foreach ($task->users as $user) {
            $cellphone[] = '57'.$user->cellphone;
            Notification::create([
                'user_id' => Auth::id(),
                'notified_id' => $user->id,
                'type' => 'task',
                'type_id' => $task->id,
                'text' => $text
            ]);
        }

        $cellphone_separated_by_comma = implode(",", $cellphone);
        SendSms::send($cellphone_separated_by_comma, $text);

        return response(json_encode($task), 201)->header('Content-Type', 'text/json');
    }
}
