@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Manage Roles')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Roles</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Roles
            </h2>
        </div>

        <div class="mt-5 mb-3 flex justify-between items-center">
            <p class="text-primary font-semibold">List of all Roles</p>

            <a href="{{ route('roles.create') }}" aria-label="add new role button">
                <x-button class="w-36">Add New Role</x-button>
            </a>
        </div>

        <div class="grid grid-cols-12 gap-5 mt-5">
            @foreach($roles as $role)
                <a class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in flex justify-between" href="{{ route('roles.show', $role) }}">
                    <div>
                        <div class="font-medium text-base">{{ $role->name }}</div>
                        <div class="text-info">{{ $role->users_count }} users</div>
                        <div class="text-slate-500">{{ $role->permissions_count }} permissions</div>
                    </div>
                    <div class="">
                        <div class="flex">
                            @foreach($role->users as $user)
                                <div class="w-9 h-9 image-fit zoom-in {{ $loop->first ? '' : '-ml-5' }} relative z-1">
                                    <img alt="{{ $user->email }} avatar" class="tooltip rounded-full " src="{{ $user->avatar }}" title="{{ $user->email }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
