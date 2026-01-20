<?php

namespace App\Livewire;

use App\Models\Absensi;
use App\Models\Pengajuan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class MonitorAbsensi extends Component
{
    public $search = '';
    public $filterMonth;
    public $filterYear;
    public $selectedInternId = null;

    public function mount()
    {
        $this->filterMonth = Carbon::now()->month;
        $this->filterYear = Carbon::now()->year;
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->filterYear, $this->filterMonth, 1)->subMonth();
        $this->filterMonth = $date->month;
        $this->filterYear = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->filterYear, $this->filterMonth, 1)->addMonth();
        $this->filterMonth = $date->month;
        $this->filterYear = $date->year;
    }

    public function goToToday()
    {
        $this->filterMonth = Carbon::now()->month;
        $this->filterYear = Carbon::now()->year;
    }

    public function selectIntern($internId)
    {
        $this->selectedInternId = $internId;
    }

    public function clearSelection()
    {
        $this->selectedInternId = null;
    }

    public function getActiveInterns()
    {
        $query = User::whereHas('pengajuan', function (Builder $q) {
            $q->where('status_pengajuan', 'accept-final');
        });

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->get();
    }

    public function getInternAttendanceData($userId)
    {
        $user = User::find($userId);
        $pengajuan = $user->pengajuan()->where('status_pengajuan', 'accept-final')->latest()->first();

        if (!$pengajuan) {
            return [
                'user' => $user,
                'pengajuan' => null,
                'calendarData' => [],
                'stats' => [
                    'hadir' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'missed' => 0,
                    'total_required' => 0,
                ],
            ];
        }

        $internshipStart = Carbon::parse($pengajuan->tanggal_mulai);
        $internshipEnd = Carbon::parse($pengajuan->tanggal_selesai);

        $startOfMonth = Carbon::createFromDate($this->filterYear, $this->filterMonth, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($this->filterYear, $this->filterMonth, 1)->endOfMonth();

        // Get all absensi for this month
        $absensiData = Absensi::where('user_id', $userId)
            ->whereMonth('tanggal', $this->filterMonth)
            ->whereYear('tanggal', $this->filterYear)
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        $weeks = [];
        $currentDate = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);

        // Stats counters
        $stats = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'missed' => 0,
            'total_required' => 0,
        ];

        while ($currentDate <= $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dateKey = $currentDate->format('Y-m-d');
                $isCurrentMonth = $currentDate->month == $this->filterMonth;
                $isWeekend = $currentDate->isWeekend();
                $isInternshipPeriod = $currentDate->between($internshipStart, $internshipEnd) && !$isWeekend;
                $absensi = $absensiData->get($dateKey);

                // Count stats for current month only
                if ($isCurrentMonth && $isInternshipPeriod && !$currentDate->isFuture()) {
                    $stats['total_required']++;
                    if ($absensi) {
                        if ($absensi->status === 'hadir')
                            $stats['hadir']++;
                        elseif ($absensi->status === 'izin')
                            $stats['izin']++;
                        elseif ($absensi->status === 'sakit')
                            $stats['sakit']++;
                    } else {
                        $stats['missed']++;
                    }
                }

                $week[] = [
                    'date' => $currentDate->copy(),
                    'dateKey' => $dateKey,
                    'day' => $currentDate->day,
                    'isCurrentMonth' => $isCurrentMonth,
                    'isToday' => $currentDate->isToday(),
                    'isInternshipPeriod' => $isInternshipPeriod,
                    'isWeekend' => $isWeekend,
                    'isFuture' => $currentDate->isFuture(),
                    'absensi' => $absensi,
                ];
                $currentDate->addDay();
            }
            $weeks[] = $week;
        }

        return [
            'user' => $user,
            'pengajuan' => $pengajuan,
            'calendarData' => $weeks,
            'stats' => $stats,
        ];
    }

    public function render()
    {
        $interns = $this->getActiveInterns();
        $selectedInternData = null;

        if ($this->selectedInternId) {
            $selectedInternData = $this->getInternAttendanceData($this->selectedInternId);
        }

        $monthName = Carbon::createFromDate($this->filterYear, $this->filterMonth, 1)->translatedFormat('F Y');

        return view('livewire.monitor-absensi', [
            'interns' => $interns,
            'selectedInternData' => $selectedInternData,
            'monthName' => $monthName,
        ]);
    }
}
