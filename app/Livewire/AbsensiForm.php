<?php

namespace App\Livewire;

use App\Models\Absensi;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AbsensiForm extends Component
{
    public $currentMonth;
    public $currentYear;
    public $selectedDate = null;

    // Form fields
    public $status = 'hadir';
    public $uraian_aktivitas = '';
    public $pembelajaran_diperoleh = '';
    public $kendala_dialami = '';
    public $verifikasi = false;
    public $showModal = false;
    public $isEditing = false;
    public $editingId = null;

    protected $rules = [
        'status' => 'required|in:hadir,izin,sakit',
        'uraian_aktivitas' => 'required|string|min:10',
        'pembelajaran_diperoleh' => 'required|string|min:10',
        'kendala_dialami' => 'nullable|string',
        'verifikasi' => 'accepted',
    ];

    protected $messages = [
        'status.required' => 'Status kehadiran wajib dipilih',
        'uraian_aktivitas.required' => 'Uraian aktivitas wajib diisi',
        'uraian_aktivitas.min' => 'Uraian aktivitas minimal 10 karakter',
        'pembelajaran_diperoleh.required' => 'Pembelajaran yang diperoleh wajib diisi',
        'pembelajaran_diperoleh.min' => 'Pembelajaran yang diperoleh minimal 10 karakter',
        'verifikasi.accepted' => 'Anda harus menyetujui pernyataan verifikasi',
    ];

    public function mount()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function goToToday()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }

    public function openModal($date)
    {
        // Validate that the date is today only
        $selectedDateCarbon = Carbon::parse($date);
        $today = Carbon::today();

        if (!$selectedDateCarbon->isSameDay($today)) {
            session()->flash('error', 'Presensi hanya dapat diisi pada hari ini saja');
            return;
        }

        $this->selectedDate = $date;
        $this->resetForm();

        // Check if absensi already exists for this date
        $user = Auth::user();
        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $date)
            ->first();

        if ($existingAbsensi) {
            $this->isEditing = true;
            $this->editingId = $existingAbsensi->id;
            $this->status = $existingAbsensi->status;
            $this->uraian_aktivitas = $existingAbsensi->uraian_aktivitas;
            $this->pembelajaran_diperoleh = $existingAbsensi->pembelajaran_diperoleh;
            $this->kendala_dialami = $existingAbsensi->kendala_dialami;
            $this->verifikasi = $existingAbsensi->verifikasi;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->status = 'hadir';
        $this->uraian_aktivitas = '';
        $this->pembelajaran_diperoleh = '';
        $this->kendala_dialami = '';
        $this->verifikasi = false;
        $this->isEditing = false;
        $this->editingId = null;
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        // Validate that the selected date is today only
        $selectedDateCarbon = Carbon::parse($this->selectedDate);
        $today = Carbon::today();

        if (!$selectedDateCarbon->isSameDay($today)) {
            session()->flash('error', 'Presensi hanya dapat diisi pada hari ini saja');
            $this->closeModal();
            return;
        }

        $user = Auth::user();
        $pengajuan = $user->pengajuan()->where('status_pengajuan', 'accept-final')->latest()->first();

        if (!$pengajuan) {
            session()->flash('error', 'Anda belum memiliki pengajuan magang yang aktif');
            return;
        }

        if ($this->isEditing && $this->editingId) {
            $absensi = Absensi::find($this->editingId);
            if ($absensi) {
                $absensi->update([
                    'status' => $this->status,
                    'uraian_aktivitas' => $this->uraian_aktivitas,
                    'pembelajaran_diperoleh' => $this->pembelajaran_diperoleh,
                    'kendala_dialami' => $this->kendala_dialami,
                    'verifikasi' => $this->verifikasi,
                ]);
                session()->flash('success', 'Presensi berhasil diperbarui');
            }
        } else {
            Absensi::create([
                'user_id' => $user->id,
                'pengajuan_id' => $pengajuan->id,
                'tanggal' => $this->selectedDate,
                'status' => $this->status,
                'uraian_aktivitas' => $this->uraian_aktivitas,
                'pembelajaran_diperoleh' => $this->pembelajaran_diperoleh,
                'kendala_dialami' => $this->kendala_dialami,
                'verifikasi' => $this->verifikasi,
            ]);
            session()->flash('success', 'Presensi berhasil disimpan');
        }

        $this->closeModal();
    }

    public function getCalendarData()
    {
        $user = Auth::user();
        $pengajuan = $user->pengajuan()->where('status_pengajuan', 'accept-final')->latest()->first();

        $startOfMonth = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->endOfMonth();

        // Get internship period
        $internshipStart = $pengajuan ? Carbon::parse($pengajuan->tanggal_mulai) : null;
        $internshipEnd = $pengajuan ? Carbon::parse($pengajuan->tanggal_selesai) : null;

        // Get all absensi for this month
        $absensiData = Absensi::where('user_id', $user->id)
            ->whereMonth('tanggal', $this->currentMonth)
            ->whereYear('tanggal', $this->currentYear)
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        $weeks = [];
        $currentDate = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);

        while ($currentDate <= $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dateKey = $currentDate->format('Y-m-d');
                $isCurrentMonth = $currentDate->month == $this->currentMonth;
                $isInternshipPeriod = false;
                $isWeekend = $currentDate->isWeekend();

                if ($internshipStart && $internshipEnd) {
                    $isInternshipPeriod = $currentDate->between($internshipStart, $internshipEnd);
                }

                $week[] = [
                    'date' => $currentDate->copy(),
                    'dateKey' => $dateKey,
                    'day' => $currentDate->day,
                    'isCurrentMonth' => $isCurrentMonth,
                    'isToday' => $currentDate->isToday(),
                    'isInternshipPeriod' => $isInternshipPeriod && !$isWeekend,
                    'isWeekend' => $isWeekend,
                    'isFuture' => $currentDate->isFuture(),
                    'absensi' => $absensiData->get($dateKey),
                ];
                $currentDate->addDay();
            }
            $weeks[] = $week;
        }

        return $weeks;
    }

    public function render()
    {
        return view('livewire.absensi-form', [
            'calendarData' => $this->getCalendarData(),
            'monthName' => Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->translatedFormat('F Y'),
        ]);
    }
}
