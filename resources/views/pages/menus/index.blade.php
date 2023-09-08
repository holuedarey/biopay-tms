        @extends('../layout/'.  config('view.menu-style'))

@section('title', 'Menus')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Services</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex sm:flex-row flex-col sm:items-center justify-between mt-8">
            <h2 class="text-lg font-medium">
                Services
            </h2>
        </div>
    </section>

    <section class="mt-8 bg-white px-5 py-3">
        <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
            <p class="font-semibold">Showing list of all terminal menus</p>
        </div>
        <div  x-data="{menu: {}, action: null}">
            <div class="intro-y overflow-auto mt-8 sm:mt-0">
                <table class="table table-report table-auto table-hover sm:mt-2">
                    <thead>
                    <tr class="bg-gray-200">
                        <th scope="col">Name</th>

                        <th scope="col">Service</th>

                        <th scope="col" class="text-center">Terminals</th>

                        <th class="text-center whitespace-nowrap">
                            <span class="flex justify-center">
                                <i data-lucide="settings" class="w-5 h-5"></i>
                            </span>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($menus as $menu)
                        <tr class="intro-x">
                            <td class="whitespace-nowrap">{{ $menu->menu_name }}</td>

                            <td class="w-56">
                                <x-badge>{{ $menu->name }}</x-badge>
                            </td>

                            <td class="text-center">
                                <span class="bg-info/20 text-info rounded-full py-1 px-2">{{ $menu->terminals_count }}</span>
                            </td>

                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <button class="flex items-center mr-3 text-blue-600"
                                            data-tw-toggle="modal" data-tw-target="#edit-menu"
                                            @click="menu = @js($menu); action = '{{ route('services.update', $menu) }}'"
                                    >
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <x-menus.edit />
        </div>
    </section>
@endsection
