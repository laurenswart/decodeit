<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class InscriptionsPerMonth extends BaseChart
{

    public ?string $routeName = 'inscriptionsPerMonth';
    public ?array $middlewares = ['adminauth'];

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        //get number of users enrolled per month
        $usersPerMonth = User::all()->
            groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m Y'); // grouping by months
            });

        $teachers = [];
        $students = [];

        $sorted = $usersPerMonth->sortBy(function($group, $key)
        {
            $bits = explode(' ',$key);
            return   mktime(0, 0, 0, intval($bits[0]), 2, intval($bits[1]));
        });
        foreach ($sorted as $key => $value) {
            //seperate into teacher/student
            $teachers[] = count($value->where('role_ref', '=', '1'));
            $students[] = count($value->where('role_ref', '=', '2'));
            $bits = explode(' ',$key);
            $keys[] =  date('M Y', mktime(0, 0, 0, intval($bits[0]), 2, intval($bits[1])));
        }
        return Chartisan::build()
            ->labels($keys)
            ->dataset('Teachers', $teachers)
            ->dataset('Students', $students);
    }
}