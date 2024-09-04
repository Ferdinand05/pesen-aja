<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'message' => $request->session()->get('message'),
            'auth.user' => fn() => $request->user()
                ? $request->user()->only('name', 'role')
                : null,
            'order' => [
                'session_id' => session('session_id'),
                'customer_name' => session('customer_name'),
                'table_number' => session('table_number')
            ],
            'payment' => [
                'snapToken' => $request->session()->get('snapToken')
            ]
        ]);
    }
}
