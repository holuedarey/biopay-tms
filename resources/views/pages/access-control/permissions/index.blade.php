@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Manage Permissions')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Permissions
        </h2>
    </div>

    <section class="mt-12 bg-white px-5 py-3">
        <p class="font-semibold text-primary">List of all Permissions</p>
        <div class="intro-y overflow-auto mt-8 sm:mt-0">
            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                <tr class="bg-gray-200">
                    <th class="whitespace-nowrap">NAME</th>
                    <th class="whitespace-nowrap">DESCRIPTION</th>
                    <th class="whitespace-nowrap">ROLES</th>
                    {{--<th class="text-center whitespace-nowrap">
                        <span class="flex justify-center">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </span>
                    </th>--}}
                </tr>
                </thead>

                <tbody>
                @foreach ($permissions as $permission)
                    <tr class="intro-x">
                        <td class="">{{ ucwords($permission->name) }}</td>

                        <td class="">{{ $permission->description ?? '...' }}</td>

                        <td><span class="text-info font-semibold">{{ $permission->roles()->pluck('name')->implode(', ') }}</span></td>

                        {{--<td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3 text-blue-600" href="">
                                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                </a>
                            </div>
                        </td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
