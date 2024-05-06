<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReportResource;
use App\Http\Resources\ReportLargeResource;
use App\Http\Requests\Api\Reports\StoreRequest;

class ReportController extends Controller
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

            $reports = Report::when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
                ->where('status', '!=', ConstantController::FINISHED)
                ->orderby('id', 'DESC')
                ->get();
        } else {

            $reports = Report::where('user_id', Auth::id())
                ->when($request->filled('date'), function ($query) use ($request) {
                    $query->whereDate('created_at', $request->date);
                })
                ->where('status', '!=', ConstantController::FINISHED)
                ->orderby('id', 'DESC')
                ->get();
        }

        return $this->respondWithCollection(ReportResource::collection($reports));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        Report::create([
            'user_id' => Auth::id(),
            'report_name' => $request->report_name,
            'description' => $request->description,
            // 'image' => upload($request->image, 'reports'),

        ]);
        $title = 'New report';
        $body = 'You Have New report';
        $users = User::whereType('manger')->get();
        foreach ($users as $user) {
            if ($user->device_token != null) {
                $this->notification->send($user->device_token, $title, $body);
            }
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
        $report = Report::with('user')->find($id);

        if (!$report) return $this->errorStatus();
        // dd('sdf');
        return $this->respondWithItem(new ReportLargeResource($report));
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
        //dd($request->all());
        $report = Report::whereId($id)->update([
            'manger_id' => Auth::id(),
            'answer' => $request->answer,
            'status' => 'done',
        ]);
        $report = Report::find($id);
        //dd($report);
        $title = 'Answer report';
        $body = 'You Have New answer';
        $user = User::find($report->user_id);
        if ($user->device_token != null) {
            $this->notification->send($user->device_token, $title, $body);
        }
        
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
        $report =  Report::find($id);
        if (!$report) return $this->errorStatus();
        $report->delete();

        return $this->successStatus();
    }
}
