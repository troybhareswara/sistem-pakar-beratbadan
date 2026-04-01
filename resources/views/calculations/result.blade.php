@extends('layouts.app')

@section('title', 'Hasil Analisis - ' . $calculation->nama)

@php
    $bmiColor = match($calculation->klasifikasi_bmi) {
        'Kurus' => 'blue',
        'Normal' => 'green',
        'Overweight' => 'yellow',
        'Obesitas' => 'red',
        default => 'gray',
    };

    $bmiRing = match($bmiColor) {
        'blue' => 'from-blue-400 to-blue-600',
        'green' => 'from-emerald-400 to-emerald-600',
        'yellow' => 'from-yellow-400 to-yellow-600',
        'red' => 'from-red-400 to-red-600',
        default => 'from-slate-400 to-slate-600',
    };

    $bmiText = match($bmiColor) {
        'blue' => 'text-blue-600',
        'green' => 'text-emerald-600',
        'yellow' => 'text-yellow-600',
        'red' => 'text-red-600',
        default => 'text-slate-600',
    };

    $bmiBg = match($bmiColor) {
        'blue' => 'bg-blue-50 text-blue-700 border-blue-200',
        'green' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'yellow' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'red' => 'bg-red-50 text-red-700 border-red-200',
        default => 'bg-slate-50 text-slate-700 border-slate-200',
    };
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 rounded-full text-emerald-700 text-sm font-medium mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Analisis Selesai
        </div>
        <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-2">
            Hasil Analisis untuk {{ $calculation->nama }}
        </h1>
        <p class="text-slate-500">{{ $calculation->created_at->format('d M Y, H:i') }} WIB</p>
    </div>

    {{-- BMI Hero Card --}}
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-slate-50 to-slate-100/50 px-6 py-4 border-b border-slate-200/60">
            <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Indeks Massa Tubuh (BMI)
            </h2>
        </div>
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-center gap-6 sm:gap-10">
                {{-- BMI Circle --}}
                <div class="relative flex-shrink-0">
                    <div class="w-36 h-36 rounded-full bg-gradient-to-br {{ $bmiRing }} p-1 shadow-lg">
                        <div class="w-full h-full rounded-full bg-white flex flex-col items-center justify-center">
                            <span class="text-4xl font-bold {{ $bmiText }}">{{ number_format($calculation->bmi, 1) }}</span>
                            <span class="text-xs text-slate-500 font-medium">BMI</span>
                        </div>
                    </div>
                    <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full text-xs font-semibold border {{ $bmiBg }}">
                        {{ $calculation->klasifikasi_bmi }}
                    </div>
                </div>

                {{-- BMI Info --}}
                <div class="flex-1 text-center sm:text-left">
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">BMI Anda: {{ number_format($calculation->bmi, 1) }}</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        @if($calculation->klasifikasi_bmi === 'Normal')
                            <span class="inline-flex items-center gap-1 text-emerald-600 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Berat badan Anda sudah ideal. Pertahankan pola makan seimbang dan gaya hidup aktif.
                            </span>
                        @elseif($calculation->klasifikasi_bmi === 'Kurus')
                            Berat badan Anda di bawah normal ({{ $calculation->berat_badan }} kg). Disarankan untuk menambah asupan kalori secara sehat dengan makanan bergizi dan olahraga teratur.
                        @elseif($calculation->klasifikasi_bmi === 'Overweight')
                            Berat badan Anda sedikit berlebih ({{ $calculation->berat_badan }} kg). Disarankan untuk mengatur pola makan dan meningkatkan aktivitas fisik.
                        @else
                            Berat badan Anda termasuk kategori obesitas ({{ $calculation->berat_badan }} kg). Sangat disarankan untuk berkonsultasi dengan dokter atau ahli gizi.
                        @endif
                    </p>
                    <div class="inline-flex items-center gap-2 text-sm text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Ukuran: {{ $calculation->berat_badan }} kg / {{ $calculation->tinggi_badan }} cm
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        {{-- BMR Card --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/60 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">BMR</p>
                    <p class="text-xs text-slate-400">Kalori dasar saat istirahat</p>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($calculation->bmr, 0) }}</p>
            <p class="text-sm text-slate-500">kkal/hari</p>
        </div>

        {{-- TDEE Card --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/60 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">TDEE</p>
                    <p class="text-xs text-slate-400">Total kebutuhan kalori</p>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($calculation->tdee, 0) }}</p>
            <p class="text-sm text-slate-500">kkal/hari</p>
        </div>

        {{-- Target Kalori Card --}}
        <div class="bg-gradient-to-br from-teal-500 to-emerald-500 rounded-2xl p-5 shadow-lg shadow-teal-500/20 text-white">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-white/80">Target Kalori</p>
                    <p class="text-xs text-white/60">
                        @if($calculation->tujuan === 'maintain')
                            Menjaga berat
                        @elseif($calculation->tujuan === 'lose')
                            Menurunkan berat
                        @else
                            Menambah berat
                        @endif
                    </p>
                </div>
            </div>
            <p class="text-3xl font-bold mb-1">{{ number_format($calculation->kalori_rekomendasi, 0) }}</p>
            <p class="text-sm text-white/80">kkal/hari</p>
        </div>
    </div>

    {{-- User Info & Recommendations Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- User Info Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100/50 px-5 py-3 border-b border-slate-200/60">
                <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Data Diri
                </h3>
            </div>
            <div class="p-5">
                <dl class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <dt class="text-slate-500 text-sm">Nama</dt>
                        <dd class="font-medium text-slate-800 text-sm">{{ $calculation->nama }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <dt class="text-slate-500 text-sm">Umur</dt>
                        <dd class="font-medium text-slate-800 text-sm">{{ $calculation->umur }} tahun</dd>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <dt class="text-slate-500 text-sm">Jenis Kelamin</dt>
                        <dd class="font-medium text-slate-800 text-sm">{{ $calculation->gender_label }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <dt class="text-slate-500 text-sm">Berat Badan</dt>
                        <dd class="font-medium text-slate-800 text-sm">{{ $calculation->berat_badan }} kg</dd>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <dt class="text-slate-500 text-sm">Tinggi Badan</dt>
                        <dd class="font-medium text-slate-800 text-sm">{{ $calculation->tinggi_badan }} cm</dd>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <dt class="text-slate-500 text-sm">Aktivitas</dt>
                        <dd class="font-medium text-slate-800 text-sm text-right">{{ $calculation->activity_label }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <dt class="text-slate-500 text-sm">Tujuan</dt>
                        <dd class="font-medium text-slate-800 text-sm">{{ $calculation->goal_label }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Recommendations Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100/50 px-5 py-3 border-b border-slate-200/60">
                <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    Rekomendasi
                </h3>
            </div>
            <div class="p-5 max-h-80 overflow-y-auto">
                @foreach(explode("\n\n", $calculation->rekomendasi) as $paragraph)
                    @if(trim($paragraph))
                        <div class="flex gap-3 mb-4 last:mb-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-teal-500 mt-2 flex-shrink-0"></div>
                            <p class="text-slate-700 text-sm leading-relaxed">{{ trim($paragraph) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('export.pdf', $calculation->id) }}"
            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-xl font-semibold hover:from-teal-600 hover:to-emerald-600 transition-all shadow-lg shadow-teal-500/20 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download PDF
        </a>
        <a href="{{ route('history') }}"
            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Lihat Riwayat
        </a>
        <a href="{{ route('home') }}"
            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-slate-300 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Hitung Lagi
        </a>
    </div>
</div>
@endsection
