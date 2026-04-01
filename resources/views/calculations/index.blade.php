@extends('layouts.app')

@section('title', 'Kalkulator BMI & Kalori')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Hero Section --}}
    <div class="text-center mb-10">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-teal-50 rounded-full text-teal-700 text-sm font-medium mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Analisis Instan & Akurat
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold text-slate-900 mb-4 tracking-tight">
            Kalkulator <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-emerald-500">BMI & Kalori</span>
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Hitung kebutuhan kalori harian Anda dengan formulas Mifflin-St Jeor. Dapatkan rekomendasi nutrisi yang dipersonalisasi.
        </p>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200/60 overflow-hidden">
        {{-- Form Header --}}
        <div class="bg-gradient-to-r from-teal-500 to-emerald-500 px-6 py-4">
            <h2 class="text-white font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Masukkan Data Diri
            </h2>
        </div>

        <form action="{{ route('calculate.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            {{-- Nama --}}
            <div class="space-y-2">
                <label for="nama" class="block text-sm font-semibold text-slate-700">
                    Nama Lengkap
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                        class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all placeholder:text-slate-400 @error('nama') border-red-500 bg-red-50 @enderror"
                        placeholder="Masukkan nama lengkap Anda" required>
                </div>
                @error('nama')
                    <p class="text-red-600 text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Two Column Grid: Umur & Gender --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Umur --}}
                <div class="space-y-2">
                    <label for="umur" class="block text-sm font-semibold text-slate-700">
                        Umur (tahun)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="number" name="umur" id="umur" value="{{ old('umur') }}" min="1" max="120"
                            class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all placeholder:text-slate-400 @error('umur') border-red-500 bg-red-50 @enderror"
                            placeholder="Contoh: 25" required>
                    </div>
                    @error('umur')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">
                        Jenis Kelamin
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="laki" class="peer sr-only"
                                {{ old('jenis_kelamin') === 'laki' ? 'checked' : '' }} required>
                            <div class="flex items-center justify-center gap-2 px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 peer-checked:bg-teal-50 peer-checked:border-teal-500 peer-checked:text-teal-700 transition-all hover:bg-slate-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">Laki-laki</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="perempuan" class="peer sr-only"
                                {{ old('jenis_kelamin') === 'perempuan' ? 'checked' : '' }} required>
                            <div class="flex items-center justify-center gap-2 px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 peer-checked:bg-teal-50 peer-checked:border-teal-500 peer-checked:text-teal-700 transition-all hover:bg-slate-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">Perempuan</span>
                            </div>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Two Column Grid: Berat & Tinggi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="berat_badan" class="block text-sm font-semibold text-slate-700">
                        Berat Badan (kg)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                        </div>
                        <input type="number" name="berat_badan" id="berat_badan" value="{{ old('berat_badan') }}"
                            step="0.1" min="1" max="500"
                            class="w-full pl-12 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all placeholder:text-slate-400 @error('berat_badan') border-red-500 bg-red-50 @enderror"
                            placeholder="Contoh: 70.5" required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-sm">
                            kg
                        </div>
                    </div>
                    @error('berat_badan')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="tinggi_badan" class="block text-sm font-semibold text-slate-700">
                        Tinggi Badan (cm)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                            </svg>
                        </div>
                        <input type="number" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan') }}"
                            step="0.1" min="30" max="300"
                            class="w-full pl-12 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all placeholder:text-slate-400 @error('tinggi_badan') border-red-500 bg-red-50 @enderror"
                            placeholder="Contoh: 170" required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-sm">
                            cm
                        </div>
                    </div>
                    @error('tinggi_badan')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Tingkat Aktivitas --}}
            <div class="space-y-2">
                <label for="tingkat_aktivitas" class="block text-sm font-semibold text-slate-700">
                    Tingkat Aktivitas
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <select name="tingkat_aktivitas" id="tingkat_aktivitas"
                        class="w-full pl-12 pr-10 appearance-none bg-slate-50 border border-slate-200 rounded-xl py-3.5 focus:bg-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all @error('tingkat_aktivitas') border-red-500 bg-red-50 @enderror cursor-pointer"
                        required>
                        <option value="">Pilih tingkat aktivitas</option>
                        <option value="sedenter" {{ old('tingkat_aktivitas') === 'sedenter' ? 'selected' : '' }}>
                            Sedenter — Jarang olahraga
                        </option>
                        <option value="ringan" {{ old('tingkat_aktivitas') === 'ringan' ? 'selected' : '' }}>
                            Ringan — Olahraga 1-3 hari/minggu
                        </option>
                        <option value="sedang" {{ old('tingkat_aktivitas') === 'sedang' ? 'selected' : '' }}>
                            Sedang — Olahraga 3-5 hari/minggu
                        </option>
                        <option value="berat" {{ old('tingkat_aktivitas') === 'berat' ? 'selected' : '' }}>
                            Berat — Olahraga 6-7 hari/minggu
                        </option>
                        <option value="atlet" {{ old('tingkat_aktivitas') === 'atlet' ? 'selected' : '' }}>
                            Atlet — Olahraga 2x/hari
                        </option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                @error('tingkat_aktivitas')
                    <p class="text-red-600 text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tujuan --}}
            <div class="space-y-2">
                <label for="tujuan" class="block text-sm font-semibold text-slate-700">
                    Tujuan
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="tujuan" value="maintain" class="peer sr-only"
                            {{ old('tujuan') === 'maintain' ? 'checked' : '' }} required>
                        <div class="flex flex-col items-center gap-2 px-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 peer-checked:bg-teal-50 peer-checked:border-teal-500 peer-checked:text-teal-700 transition-all hover:bg-slate-100 text-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="font-semibold text-sm">Maintain</span>
                            <span class="text-xs opacity-70">Menjaga berat</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="tujuan" value="lose" class="peer sr-only"
                            {{ old('tujuan') === 'lose' ? 'checked' : '' }} required>
                        <div class="flex flex-col items-center gap-2 px-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 peer-checked:bg-orange-50 peer-checked:border-orange-500 peer-checked:text-orange-700 transition-all hover:bg-slate-100 text-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            <span class="font-semibold text-sm">Lose Weight</span>
                            <span class="text-xs opacity-70">Menurunkan</span>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="tujuan" value="gain" class="peer sr-only"
                            {{ old('tujuan') === 'gain' ? 'checked' : '' }} required>
                        <div class="flex flex-col items-center gap-2 px-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all hover:bg-slate-100 text-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="font-semibold text-sm">Gain Weight</span>
                            <span class="text-xs opacity-70">Menambah</span>
                        </div>
                    </label>
                </div>
                @error('tujuan')
                    <p class="text-red-600 text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 text-white py-4 px-6 rounded-xl font-semibold text-lg hover:from-teal-600 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 shadow-lg shadow-teal-500/30 hover:shadow-teal-500/50 hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Hitung Sekarang
            </button>
        </form>
    </div>

    {{-- Info Cards --}}
    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/60 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-teal-100 transition-colors">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 mb-1">BMI</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Indeks Massa Tubuh untuk mengklasifikasikan berat badan Anda</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/60 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-orange-100 transition-colors">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 mb-1">BMR</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Kalori dasar harian tubuh saat istirahat sempurna</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/60 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 mb-1">TDEE</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Total kebutuhan kalori harian berdasarkan aktivitas</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
