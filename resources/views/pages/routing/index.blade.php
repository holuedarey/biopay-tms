@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Routing Types')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Routing</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8 mb-4">
            <h2 class="text-lg font-medium mr-auto">
                Routing
            </h2>

{{--            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">--}}
{{--                <a href="#" class="col-span-1 btn btn-primary shadow-sm"--}}
{{--                   data-tw-toggle="modal" data-tw-target="#create-provider"--}}
{{--                >Add New</a>--}}
{{--            </div>--}}
        </div>
    </section>

    <section class="mt-3 bg-white px-5 py-3">
        <div x-data="{type: {}, action: null}">
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
                            <th scope="col">Active</th>
                            <th scope="col">Created At</th>
                            <th class="text-center whitespace-nowrap">
                                <span class="flex justify-center">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                </span>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($types as $item)
                            <tr class="intro-x">
                                <td>{{ $loop->iteration }}</td>

                                <td class="w-56">{{ ucwords($item->name) }}</td>

                                @if($item->active)
                                    <td><x-badge>@nbsp($item->active == 1 ? 'YES' : 'NO')</x-badge></td>
                                @else
                                    <td><x-badge color="red">@nbsp($item->active == 1 ? 'YES' : 'NO')</x-badge></td>
                                @endif

                                <td>{{ $item->created_at->toDayDateTimeString() }}</td>

                                <td class="table-report__action w-40">
                                    <div class="flex justify-around gap-4 items-center">
                                        <a href="{{ route('routing.settings', $item->id) }}" class="flex items-center text-info spinner-dark">
                                            <i data-lucide="settings" class="w-4 h-4 mr-1"></i> Settings
                                        </a>
{{--                                        <form action="{{ route('routing.destroy', $item) }}" class="my-form" method="post">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button type="submit" href="#" class="flex items-center text-danger spinner-dark">--}}
{{--                                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
