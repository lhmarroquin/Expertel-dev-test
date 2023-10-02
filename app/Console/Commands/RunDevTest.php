<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Meeting;
use Illuminate\Support\Facades\Http;

class RunDevTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies the dev test';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Meeting::truncate();

        if (file_exists("/Users/juan/test_cases.json"))
        {
            $cases = json_decode(file_get_contents("/Users/juan/test_cases.json"), true);
        }
        else
        {
            $cases = [];
        }

        $success = 0;
        foreach($cases as $idx => $case)
        {

            $response = Http::post(env('APP_URL').'/api/meetings', [
                'meeting_name' => $case[0],
                'start_time' => $case[1],
                'end_time' => $case[2],
                'users' => $case[3]
            ]);


            $data = json_decode($response->body(), true);

            if ($case[4] && $data['message'] == "The meeting has been booked")
            {
                $success++;
            }
            elseif($case[4] == false && $data['message'] == "The meeting can not be booked")
            {
                $success++;
            }
            else
            {
                echo "Failed case $idx ".print_r($case,1)." response was ".print_r($data,1);
            }
        }

        echo "SCORE: ".$success." / ".count($cases);
        echo PHP_EOL;
    }
}
