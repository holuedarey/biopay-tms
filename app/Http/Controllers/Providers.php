<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class Providers extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read settings');

        $providers = ServiceProvider::with('service')->orderBy('name')->get();
        $services = Service::orderBy('name')->get();

        return view('pages.providers.index', compact('providers', 'services'));
    }

    public function store(Request $request)
    {
        $request->user()->can('create settings');

        $request->validate([
            'name' => 'required|string',
            'services.*' => 'required|exists:services,id'
        ]);

        $request->collect('services')->each(
            fn($id) => ServiceProvider::create([
                'service_id' =>  $id,
                'name' => $request->get('name')
            ])
        );

        return back()->with('success', 'New Provider added!');
    }

    public function destroy(Request $request, ServiceProvider $provider)
    {
        $request->user()->can('edit settings');

        if (Service::whereProviderId($provider->id)->exists())
            return back()->with('error', "Cannot be deleted because it's currently selected.");

        $provider->delete();

        return back()->with('success', 'Service provider deleted.');
    }
}
