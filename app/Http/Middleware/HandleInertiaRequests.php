<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Consultation;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            // Hitung konsultasi yang belum dibaca, hanya untuk super_admin
            'unreadConsultationsCount' => function () use ($request) {
                if ($request->user() && $request->user()->role === 'super_admin') {
                    return Consultation::where('is_read', false)->count();
                }
                return 0;
            },
        ];
    }
}