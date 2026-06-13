<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Format;
use App\Models\Medium;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\User;
use App\Models\StudentAnswerHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $studentsQuery = User::where('role_id', 3);

        $totalStudents = (clone $studentsQuery)->count();
        $activeStudents = (clone $studentsQuery)->where('is_active', 1)->count();
        $pendingStudents = (clone $studentsQuery)->where('is_active', 0)->count();
        $revenue = (clone $studentsQuery)->sum('amount');

        $standardWiseStudents = DB::table('standards')
            ->leftJoin('users', function ($join) {
                $join->on('users.standard', '=', 'standards.id')
                    ->where('users.role_id', 3);
            })
            ->whereIn('standards.is_active', [0, 1])
            ->groupBy('standards.id', 'standards.name')
            ->selectRaw('standards.name, COUNT(users.id) as students')
            ->orderBy('standards.name')
            ->get();

        $mediumWiseStudents = DB::table('media')
            ->leftJoin('users', function ($join) {
                $join->on('users.medium', '=', 'media.id')
                    ->where('users.role_id', 3);
            })
            ->whereIn('media.is_active', [0, 1])
            ->groupBy('media.id', 'media.name')
            ->selectRaw('media.name, COUNT(users.id) as students')
            ->orderBy('media.name')
            ->get();

        $contentStats = [
            'standards' => Standard::whereIn('is_active', [0, 1])->count(),
            'mediums' => Medium::whereIn('is_active', [0, 1])->count(),
            'subjects' => Subject::whereIn('is_active', [0, 1])->count(),
            'chapters' => Chapter::whereIn('is_active', [0, 1])->count(),
            'videos' => Format::where('type', 1)->where('is_active', 1)->count(),
            'audios' => Format::where('type', 0)->where('is_active', 1)->count(),
            'pdfs' => Format::where('type', 2)->where('is_active', 1)->count(),
        ];

        $revenueByMonth = $this->getRevenueByMonth();
        $revenueByPaymentType = User::where('role_id', 3)
            ->whereNotNull('amount')
            ->selectRaw('COALESCE(payment_type, "Unknown") as payment_type, SUM(amount) as total')
            ->groupBy('payment_type')
            ->get();

        $recentActivities = $this->getRecentActivities();

        return view('home', compact(
            'totalStudents',
            'activeStudents',
            'pendingStudents',
            'revenue',
            'standardWiseStudents',
            'mediumWiseStudents',
            'contentStats',
            'revenueByMonth',
            'revenueByPaymentType',
            'recentActivities'
        ));
    }

    private function getRevenueByMonth(): array
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->put($date->format('Y-m'), [
                'label' => $date->format('M Y'),
                'total' => 0,
            ]);
        }

        $records = User::where('role_id', 3)
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month_key, SUM(amount) as total')
            ->groupBy('month_key')
            ->pluck('total', 'month_key');

        return $months->map(function ($item, $key) use ($records) {
            $item['total'] = (float) ($records[$key] ?? 0);

            return $item;
        })->values()->all();
    }

    private function getRecentActivities()
    {
        $activities = collect();

        User::where('role_id', 3)
            ->latest()
            ->take(5)
            ->get(['id', 'name', 'created_at'])
            ->each(function ($user) use ($activities) {
                $activities->push([
                    'type' => 'Student Registered',
                    'description' => $user->name . ' registered as a new student',
                    'time' => $user->created_at,
                ]);
            });

        Chapter::latest()
            ->take(5)
            ->get(['id', 'name', 'created_at'])
            ->each(function ($chapter) use ($activities) {
                $activities->push([
                    'type' => 'Chapter Added',
                    'description' => 'New chapter "' . $chapter->name . '" was added',
                    'time' => $chapter->created_at,
                ]);
            });

        Format::join('chapters', 'chapters.id', '=', 'formats.chapter_id')
            ->latest('formats.created_at')
            ->take(5)
            ->get(['formats.type', 'formats.created_at', 'chapters.name as chapter_name'])
            ->each(function ($format) use ($activities) {
                $typeLabel = match ((int) $format->type) {
                    0 => 'Audio',
                    1 => 'Video',
                    2 => 'PDF',
                    default => 'Content',
                };

                $activities->push([
                    'type' => 'Content Uploaded',
                    'description' => $typeLabel . ' uploaded for chapter "' . $format->chapter_name . '"',
                    'time' => $format->created_at,
                ]);
            });

        StudentAnswerHistory::join('users', 'users.id', '=', 'student_answer_histories.user_id')
            ->join('chapters', 'chapters.id', '=', 'student_answer_histories.chapter_id')
            ->latest('student_answer_histories.created_at')
            ->take(5)
            ->get(['users.name as user_name', 'chapters.name as chapter_name', 'student_answer_histories.created_at'])
            ->each(function ($attempt) use ($activities) {
                $activities->push([
                    'type' => 'Quiz Attempt',
                    'description' => $attempt->user_name . ' attempted quiz in "' . $attempt->chapter_name . '"',
                    'time' => $attempt->created_at,
                ]);
            });

        return $activities
            ->sortByDesc('time')
            ->take(10)
            ->values();
    }

}
