@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Settings & Configurations')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Settings & Configurations</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Settings & Configurations
            </h2>
        </div>
    </section>

    <section class="mt-12 bg-white px-5 py-3">
        <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
            <p class="font-semibold">Showing list of all Settings & Configurations</p>

{{--            <div class="sm:mb-0 mb-3">--}}
{{--                <a href="{{ route('Settings & Configurations.create') }}"><x-button class="w-48">Add New Terminal</x-button></a>--}}
{{--            </div>--}}
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
                        @if($services->count() > 0)

                            @foreach ($services as $service)
                                <tr class="intro-x">
                                    <td class="w-56">{{ ucwords($service->name) }}</td>

                                    <td class="">{{ $service->description }}</td>

                                    <td class="w-64">
                                        <form action="">
                                            <div class="flex items-end">
                                                <div class="w-56">
                                                    <select class="form-select" name="provider"  id="provider">
                                                        @if($service->providers->count() > 0)
                                                            @foreach($service->providers as $provider)
                                                                <option value="{{ $provider->slug }}" @if($provider->is_active) selected @endif>{{ $provider->name }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="" disabled selected>No Provider</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                @if($service->providers->count() > 1)
                                                    <div class="ml-3">
                                                        <button type="submit" class="btn btn-primary w-24 py-1">Change</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    </td>

                                    <td class="table-report__action w-48">
                                        <div class="flex justify-around items-center">
                                            @if($service->is_available)
                                                <a href="javascript:;" class="text-green-600 tooltip" title="Deactivate">
                                                    <i data-lucide="toggle-right" class="w-4 h-4 mr-1"></i>
                                                </a>
                                            @else
                                                <a href="javascript:;" class="text-danger tooltip" title="Activate">
                                                    <i data-lucide="toggle-left" class="w-4 h-4 mr-1"></i>
                                                </a>
                                            @endif
                                            <a href="#" class="flex items-center text-blue-600">
                                                <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        @else
                            <tr class="intro-x"><td colspan="10" class="text-center">No Terminal has been added yet</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
