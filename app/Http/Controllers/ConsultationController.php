<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConsultationController extends Controller
{
    // Tampilkan form konsultasi (publik)
    public function create()
    {
        return Inertia::render('Consultation/Index');
    }

    // Simpan data konsultasi (publik)
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'business' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'email'    => 'required|email|max:255',
            'message'  => 'required|string|max:500',
        ]);

        Consultation::create($request->only([
            'name', 'business', 'whatsapp', 'email', 'message'
        ]));

        return back()->with('success', 'Your message has been sent! Admin will contact you for further consultation.');
    }

    // Tampilkan semua data konsultasi (SuperAdmin)
    // Otomatis mark semua sebagai read saat halaman dibuka
    public function index()
    {
        $consultations = Consultation::latest()->get();

        // Mark semua sebagai sudah dibaca
        Consultation::where('is_read', false)->update(['is_read' => true]);

        return Inertia::render('SuperAdmin/Partials/Consultations', [
            'consultations' => $consultations,
        ]);
    }

    // Hapus data konsultasi (SuperAdmin)
    public function destroy($id)
    {
        Consultation::findOrFail($id)->delete();

        return back()->with('success', 'Consultation deleted successfully.');
    }
}