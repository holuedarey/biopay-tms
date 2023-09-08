@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Services & Providers')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('services.index') }}">Services</a></li>
    <li class="breadcrumb-item active" aria-current="page">Providers</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8 mb-4">
            <h2 class="text-lg font-medium mr-auto">
                Services
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="{{ route('providers.index') }}" class="col-span-1 btn btn-primary shadow-sm">Manage Providers</a>
            </div>
        </div>
    </section>

    <section class="mt-3 bg-white px-5 py-3">
        <div x-data="{service: {}, action: null}">
            <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
                <p class="font-semibold">Showing list of all Services & Providers</p>
            </div>
            <div >
                <div class="intro-y overflow-auto lg:overflow-visible">
                    <table class="table table-report table-auto table-hover sm:mt-2">
                        <thead>
                        <tr class="bg-gray-200">
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Provider</th>
                            <th class="text-center whitespace-nowrap">
                                <span class="flex justify-center">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                </span>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($services as $service)
                            <tr class="intro-x">
                                <td class="w-56">{{ ucwords($service->name) }}</td>

                                <td class="whitespace-nowrap">{{ $service->description }}</td>

                                <td class="w-64">
                                    @if($service->internal)
                                        <div class="w-56 py-1.5 px-3 border rounded shadow-sm">INTERNAL</div>
                                    @else
                                        <livewire:provider-select :service="$service" />
                                    @endif
                                </td>

                                <td class="table-report__action w-40">
                                    <div class="flex justify-around gap-4 items-center">
                                        <livewire:service-status :service="$service" />

                                        <a href="#" class="flex items-center text-blue-600"
                                           data-tw-toggle="modal" data-tw-target="#edit-service"
                                           @click="service = @js($service); action = '{{ route('services.update', $service) }}'"
                                        >
                                            <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <x-services.edit />
        </div>
    </section>
@endsection
