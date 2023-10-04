<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingRequest;
use Illuminate\Http\Request;
use App\Services\MeetingService;
use App\Models\Meeting;
use DateTime;
use Exception;

class MeetingController extends Controller
{
    //do not modify, required for testing
    public function list(Request $request)
    {
        return response()->json(Meeting::all());
    }

    //do not modify, required for testing
    public function delete(Request $request)
    {
        Meeting::all()->delete();
        return response()->json(true);
    }


    //modify in any way you want
    public function create(MeetingRequest $request)
    {

        $service = new MeetingService;
        $meetingName = $request->input('meeting_name');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $users = $request->input('users');

        $users = explode(',', $users);

        //add any parameters you wish
        if ($service->scheduleMeeting($meetingName, $startTime, $endTime, $users))
        {
            return response()->json(["message" => "The meeting has been booked"]);
        }
        else
        {
            return response()->json(["message" => "The meeting can not be booked"]);
        }
    }
}
