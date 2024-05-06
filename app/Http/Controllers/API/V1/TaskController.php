<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Task;
use App\Models\ToDo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TaskLargeResource;
use App\Http\Requests\Api\Tasks\StoreRequest;

class TaskController extends Controller
{
    public $notification;
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->type == ConstantController::MANGER) {

            $tasks = Task::when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
                ->orderby('id', 'DESC')
                ->get();
        } else {
            $tasks = Task::when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
                ->where('user_id', Auth::id())
                ->where('status', '!=', ConstantController::FINISHED)
                ->orderby('id', 'DESC')
                ->get();
        }
        return $this->respondWithCollection(TaskResource::collection($tasks));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Auth::user()->type != ConstantController::MANGER) {
            return $this->errorStatus('You Are Not Manger');
        }
        $task =  Task::create([
            'user_id' => $request->user_id,
            'task_name' => $request->task_name,
            'description' => $request->description,
            //'image' => upload($request->image, 'tasks'),
        ]);

        foreach ($request->todos as $todo) {
            $task->todo()->create(['title' => $todo]);
        }
        $title = 'New Call';
        $body = 'You Have New Call';
        $user = User::find($request->user_id);
        if ($user->device_token != null) {
            $this->notification->send($user->device_token, $title, $body);
        }
        return $this->successStatus();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) return $this->errorStatus();

        return $this->respondWithItem(new TaskLargeResource($task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task =  Task::where('user_id', Auth::id())->whereId($id)->first();

        if (!$task) return $this->errorStatus('task not found');

        $task->update([
            'note' => $request->note,
            'status' => 'done',
        ]);
        return $this->successStatus();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
