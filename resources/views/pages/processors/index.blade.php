@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Processors')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Processors</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8 mb-4">
            <h2 class="text-lg font-medium mr-auto">
                Processors
            </h2>

            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="#" class="col-span-1 btn btn-primary shadow-sm"
                   data-tw-toggle="modal" data-tw-target="#create-provider"
                >Add New Processor</a>
            </div>
        </div>
    </section>

    <section class="mt-3 bg-white px-5 py-3">
        <div x-data="{processor: {}, action: null}">
            <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
                <p class="font-semibold">Showing list of all Routing types</p>
            </div>
            <div >
                <div class="intro-y overflow-auto lg:overflow-visible">
                    <table class="table table-report table-auto table-hover sm:mt-2">
                        <thead>
                        <tr class="bg-gray-200">
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Host</th>
                            <th scope="col">Port</th>
                            <th scope="col">Date Created</th>
                            <th class="text-center whitespace-nowrap">
                                <span class="flex justify-center">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                </span>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($processors as $processor)
                            <tr class="intro-x">
                                <td>{{ $loop->iteration }}</td>

                                <td class="w-56">{{ $processor->name }}</td>
                                <td class="w-56">{{ $processor->host }}</td>
                                <td class="w-56">{{ $processor->port }}</td>
                                <td class="whitespace-nowrap">{{ $processor->created_at->toDayDateTimeString() }}</td>

                                <td class="table-report__action w-40">
                                    <div class="flex justify-around gap-4 items-center">
                                        <a href="#" class="flex items-center text-primary"
                                           data-tw-toggle="modal" data-tw-target="#edit-processor"
                                           @click="action = '{{ route('processors.update', $processor) }}'; processor = @js($processor);"
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

            <!-- Modals -->
            <x-processors.edit />
        </div>
    </section>
@endsection
