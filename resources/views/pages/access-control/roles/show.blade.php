@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Manage Roles')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $role->name }} Role</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center gap-2 mt-6 mb-2">
            <h2 class="text-lg font-medium">
                {{ $role->name }} Role
                <!-- BEGIN: Modal toggle -->
            </h2>
            @can('update', $role)
                <div class="text-xs sm:px-2 flex items-center text-info hover:underline cursor-pointer"
                     data-tw-toggle="modal" data-tw-target="#role-edit-modal"
                >
                    <i data-lucide="edit" class="w-3 h-3 mr-1"></i>
                    Edit role name & permissions
                </div>
            @endcan
        </div>
    </section>

    <section class="mt-6">
        <div class="flex md:flex-row flex-col-reverse justify-between md:items-end">
            @unless($role->name == \App\Models\Role::APPROVER)
                <div class="md:relative">
                    <p class="text-primary font-semibold md:absolute md:w-56 md:bottom-1 text-sm">List of {{ $role->name }} Permissions</p>
                </div>
            @endunless

            <div class="md:text-right md:mb-2 mb-4 md:ml-auto">
                <form action="{{ route('roles.users.store', $role->name) }}" method="post" class="my-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-9 gap-4">
                        <label for="new-user" class="md:col-span-2 mt-2">New User(s)</label>
                        <div class="sm:col-span-5 lg:col-span-6">
                            <input type="text" id="new-user" class="form-control" aria-label="Add new user to role"
                                   name="emails" placeholder="johndoe@test.com,janedoe@test.com" required
                            >
                            <span class="text-xs text-info">Separate multiple user emails with commas</span>
                        </div>

                        <div class="md:col-span-1 mt-1">
                            <button type="submit" class="btn btn-primary w-full md:w-24 py-1">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @unless($role->name == \App\Models\Role::APPROVER)
            <div class="box p-5 my-4">
                @if($role->permissions->isEmpty())
                    <div class="text-center">This role does not have any permission.</div>
                @else
                    <p>
                        @foreach($role->permissions->sortBy('name') as $permission)
                            {{ ucwords(str($permission->name)->replace('-', ' ')) }}{{ !$loop->last ? ', ' : '.'}}
                        @endforeach
                        <span class="text-xs flex items-center text-info hover:underline cursor-pointer"
                              data-tw-toggle="modal" data-tw-target="#role-edit-modal"
                        >
                        <i data-lucide="edit" class="w-3 h-3 mr-1"></i>
                        Edit role name & permissions
                    </span>
                    </p>
                @endif
            </div>
        @endunless
    </section>


    <section>
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Users Table -->
                <livewire:users-table name="{{ $role->name }}" :role="$role" :show-role="false" :show-action="false" :role-action="$role->name"/>
                <!-- END: Users Table -->
            </div>
        </div>
    </section>

    @can('update', $role)
        <!-- BEGIN: Modal Content -->
        <x-modal modal-id="role-edit-modal" modal-title="Edit Name and Permissions">
            <form action="{{ route('roles.update', $role) }}" method="post" class="my-form col-span-12 check-permissions-change">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-12 gap-4 mb-6">
                    <div class="col-span-12 lg:col-span-6">
                        <label for="gender" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name"
                               value="{{ old('name') ?? $role->name }}" required
                        />
                        <x-input-error :input-name="$error = 'name'" />
                    </div>
                </div>
                <div>
                    <label class="form-label text-primary font-semibold">Permissions</label>
                    <div class="grid grid-cols-6 lg:grid-cols-8">
                        @foreach($permissions as $permission)
                            <div class="col-span-6 sm:col-span- md:col-span-2 lg:col-span-2">
                                <input id="{{ $slug = str($permission)->slug() }}" class="form-check-input" type="checkbox"
                                       name="permissions[]" value="{{ $permission }}"
                                       @if(in_array($permission, $role->permissions->pluck('name')->toArray())) checked @endif
                                >
                                <label class="form-check-label" for="{{  $slug }}">{{ ucwords(str($permission)->replace('-', ' ')) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end mt-7 pt-3 border-t">
                    <button type="submit" class="btn btn-primary w-24 py-1">Update</button>
                </div>
            </form>
        </x-modal>

    @endcan
@endsection

@push('script')
{{--    @vite('resources/js/pages/permissions.js')--}}
@endpush
