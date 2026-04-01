@extends('layouts.app')

@section('title', 'Riwayat Analisis')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-1">Riwayat Analisis</h1>
            <p class="text-slate-500">Semua hasil perhitungan yang telah disimpan</p>
        </div>
        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-xl font-semibold hover:from-teal-600 hover:to-emerald-600 transition-all shadow-lg shadow-teal-500/20 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Hitung Baru
        </a>
    </div>

    {{-- Empty State --}}
    @if($calculations->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/60 p-12 text-center">
            <div class="w-20 h-20 bg-teal-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Riwayat</h2>
            <p class="text-slate-500 mb-6 max-w-sm mx-auto">Mulai dengan menghitung BMI dan kebutuhan kalori Anda untuk melihat hasil di sini</p>
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-xl font-semibold hover:from-teal-600 hover:to-emerald-600 transition-all shadow-lg shadow-teal-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Mulai Perhitungan
            </a>
        </div>
    @else
        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-50 to-slate-100/50 border-b border-slate-200/60">
                            <th class="px-5 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Pengguna
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                BMI
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Klasifikasi
                            </th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Target Kalori
                            </th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($calculations as $calc)
                            @php
                                $badgeClass = match($calc->klasifikasi_bmi) {
                                    'Kurus' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'Normal' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Overweight' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    'Obesitas' => 'bg-red-50 text-red-700 border-red-200',
                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <tr class="hover:bg-teal-50/30 transition-colors group">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-xl flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                                            {{ strtoupper(substr($calc->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $calc->nama }}</p>
                                            <p class="text-xs text-slate-400">{{ $calc->gender_label }} · {{ $calc->umur }} th</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-medium text-slate-700">{{ $calc->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-slate-400">{{ $calc->created_at->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-lg font-bold text-slate-800">{{ number_format($calc->bmi, 1) }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full border {{ $badgeClass }}">
                                        {{ $calc->klasifikasi_bmi }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ number_format($calc->kalori_rekomendasi, 0) }}</p>
                                    <p class="text-xs text-slate-400">kkal/hari</p>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('result', $calc->id) }}"
                                            class="p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-all"
                                            title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('export.pdf', $calc->id) }}"
                                            class="p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-all"
                                            title="Download PDF">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('destroy', $calc->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($calculations->hasPages())
                <div class="px-5 py-4 bg-slate-50 border-t border-slate-200/60">
                    {{ $calculations->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
