<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use App\Services\ExpertSystemService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function index()
    {
        return view('calculations.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:1|max:120',
            'jenis_kelamin' => 'required|in:laki,perempuan',
            'berat_badan' => 'required|numeric|min:1|max:500',
            'tinggi_badan' => 'required|numeric|min:30|max:300',
            'tingkat_aktivitas' => 'required|in:sedenter,ringan,sedang,berat,atlet',
            'tujuan' => 'required|in:maintain,lose,gain',
        ]);

        $data = ExpertSystemService::processCalculation($validated);

        $calculation = Calculation::create($data);

        return redirect()->route('result', $calculation->id);
    }

    public function result(Calculation $calculation)
    {
        return view('calculations.result', compact('calculation'));
    }

    public function history()
    {
        $calculations = Calculation::orderBy('created_at', 'desc')->paginate(10);
        return view('calculations.history', compact('calculations'));
    }

    public function exportPdf(Calculation $calculation)
    {
        $pdf = Pdf::loadView('calculations.pdf', compact('calculation'));

        $fileName = 'analisis_' . str_replace(' ', '_', $calculation->nama) . '_' . $calculation->created_at->format('Ymd') . '.pdf';

        return $pdf->download($fileName);
    }

    public function destroy(Calculation $calculation)
    {
        $calculation->delete();

        return redirect()->route('history')->with('success', 'Data berhasil dihapus.');
    }
}
