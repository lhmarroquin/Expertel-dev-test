<?php
namespace App\Services;

use App\Models\Meeting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


class MeetingService
{

    /**
     *
     *  MODIFY THIS FUNCTION TO YOUR LIKING
     * YOU CAN ADD AS MANY PARAMETERS AS YOU WANT
     *
     */
    public function scheduleMeeting(string $meetingName, string $startTime, string $endTime, array $users)
    {
        //check that the meeting doesn't have any conflict
        //DB::enableQueryLog(); // Enable query log
        $meeting = Meeting::whereIn('user_id', $users)
            ->where(function (Builder $query) use ($startTime,$endTime) {
                $query->where('start_time','>=',$startTime)
                    ->where('start_time','<=',$endTime);
            })
            ->orWhere(function (Builder $query) use ($startTime,$endTime) {
                $query->where('end_time','>=',$startTime)
                    ->where('end_time','<=',$endTime);
            })
            ->orWhere(function (Builder $query) use ($startTime,$endTime) {
                $query->where('start_time','<=',$startTime)
                    ->where('end_time','>=',$endTime);
            })
            ->orWhere(function (Builder $query) use ($startTime,$endTime) {
                $query->where('start_time','>=',$startTime)
                    ->where('end_time','<=',$endTime);
            })
            ->get();
        //dd(DB::getQueryLog()); // Show results of log
        $boolAble = !count($meeting);

        //save the meeting to the database
        if( $boolAble ) {
            foreach( $users as $key => $value ) {
                Meeting::insert([
                    'meeting_name' => $meetingName,
                    'start_time'   => $startTime,
                    'end_time'     => $endTime,
                    'user_id'      => $value,
                ]);
            }
        }

        //return true if able to book, otherwise return false
        return $boolAble;
    }
}
