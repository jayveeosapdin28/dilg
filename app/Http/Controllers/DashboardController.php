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

        return inertia('Dashboard',[
            'data' => [
               [
                   'name' => 'Tasks',
                   'icon'=> 'bi bi-card-checklist',
                   'stat' =>  Task::count(),
                   'link' =>  '/admin/tasks',
                   'change' => $this->calculateStatsPercentage(Task::class)['percentageChange'],
                   'changeType' => $this->calculateStatsPercentage(Task::class)['changeType'],
               ],
                [
                   'name' => 'Events',
                   'stat' =>  Event::count(),
                    'link' =>  '/admin/events',
                    'icon'=> 'bi bi-calendar2-week',
                    'change' => $this->calculateStatsPercentage(Event::class)['percentageChange'],
                    'changeType' => $this->calculateStatsPercentage(Event::class)['changeType'],
               ],
                [
                   'name' => 'Cases',
                   'stat' =>  CaseFile::count(),
                    'link' =>  '/admin/cases',
                    'icon'=> 'bi bi-folder2',
                    'change' => $this->calculateStatsPercentage(CaseFile::class)['percentageChange'],
                    'changeType' => $this->calculateStatsPercentage(CaseFile::class)['changeType'],
               ],
                [
                   'name' => 'Documents',
                   'stat' =>  Document::count(),
                    'link' =>  '/admin/documents',
                    'icon'=> 'bi bi-files',
                    'change' => $this->calculateStatsPercentage(Document::class)['percentageChange'],
                    'changeType' => $this->calculateStatsPercentage(Document::class)['changeType'],
               ],
            ]
        ]);
    }

    protected function calculateStatsPercentage($modelClass)
    {
        $todayStart = Carbon::now()->startOfDay();
        $todayEnd = Carbon::now()->endOfDay();

        $yesterdayStart = Carbon::now()->subDay()->startOfDay();
        $yesterdayEnd = Carbon::now()->subDay()->endOfDay();

        $totalSubscribersToday = $modelClass::whereBetween('created_at', [$todayStart, $todayEnd])->count();
        $totalSubscribersYesterday = $modelClass::whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])->count();

        $change = $totalSubscribersToday - $totalSubscribersYesterday;
        $changeType = $change > 0 ? 'increase' : ($change < 0 ? 'decrease' : 'no change');
        $percentageChange = $totalSubscribersYesterday > 0
            ? ($change / $totalSubscribersYesterday) * 100
            : 0;


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
