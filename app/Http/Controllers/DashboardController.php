<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Case\CaseFile;
use App\Models\Document\Document;
use App\Models\Event\Event;
use App\Models\Task\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $is_admin = in_array(auth()->user()->role, ['Admin', 'Super Admin']);


        return inertia('Dashboard',[
            'data' => [
               [
                   'name' => 'Tasks',
                   'icon'=> 'bi bi-card-checklist',
                   'stat' =>  $is_admin ? Task::count() : Task::whereJsonContains('users', auth()->user()->id)->count() ,
                   'link' =>  '/admin/tasks',
               ],
                [
                   'name' => 'Events',
                   'stat' =>  Event::count(),
                    'link' =>  '/admin/events',
                    'icon'=> 'bi bi-calendar2-week',
               ],
                [
                   'name' => 'Cases',
                   'stat' =>  $is_admin ? CaseFile::count() : CaseFile::where('user_id',auth()->user()->id)->count(),
                    'link' =>  '/admin/cases',
                    'icon'=> 'bi bi-folder2',
               ],
//                [
//                   'name' => 'Documents',
//                   'stat' =>  Document::count(),
//                    'link' =>  '/admin/documents',
//                    'icon'=> 'bi bi-files',
//                    'change' => $this->calculateStatsPercentage(Document::class)['percentageChange'],
//                    'changeType' => $this->calculateStatsPercentage(Document::class)['changeType'],
//               ],
            ]
        ]);
    }

    protected function calculateStatsPercentage($modelClass)
    {
        // Define the start and end of today
        $todayStart = Carbon::now()->startOfDay();
        $todayEnd = Carbon::now()->endOfDay();

        // Get the total records created today
        $totalRecordsToday = $modelClass::whereBetween('created_at', [$todayStart, $todayEnd])->count();

        // Get the total records excluding today's records (i.e., previous records)
        $totalRecordsPrevious = $modelClass::count() - $totalRecordsToday;

        // Calculate the change and percentage
        $change = $totalRecordsToday - $totalRecordsPrevious;
        $changeType = $change > 0 ? 'increase' : ($change < 0 ? 'decrease' : 'no change');
        $percentageChange = $totalRecordsPrevious > 0
            ? ($change / $totalRecordsPrevious) * 100
            : 0;

        // Format the percentage change
        $formattedPercentageChange = $change > 0
            ? '+' . number_format($percentageChange, 1) . '%'
            : ($change < 0
                ? '-' . number_format(abs($percentageChange), 1) . '%'
                : '0.0%');

        return [
            'change' => abs($change),
            'changeType' => $changeType,
            'percentageChange' => $formattedPercentageChange,
        ];
    }

}
