<?php

namespace App\Http\Controllers;

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
    public function create(Request $request)
    {
        $service = new MeetingService;

        //add any parameters you wish
        if ($service->scheduleMeeting())
        {
            return response()->json(["message" => "The meeting has been booked"]);
        }
        else
        {
            return response()->json(["message" => "The meeting can not be booked"]);
        }
    }
}
