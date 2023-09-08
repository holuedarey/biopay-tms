@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Manage Users')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add New Role</li>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Add New Role
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 md:col-span-10 lg:col-span-9">
            <!-- BEGIN: Form Layout -->
            <form class="intro-y box p-5" method="post" action="{{ route('roles.store') }}">
                @csrf

                <div class="grid grid-cols-12 gap-4 mt-6">
                    <div class="col-span-12 lg:col-span-6">
                        <label for="gender" class="form-label">Name</label>
                        <input type="text" class="form-control" placeholder="Enter new role name" aria-label="new role name"
                               name="name" value="{{ old('name') }}" required
                        />
                        <x-input-error :input-name="$error = 'name'" />
                    </div>
                    <div class="col-span-12 lg:col-span-6">
                        <label class="form-label" id="type">Role Type</label>
                        <select class="form-select" aria-label="Select Agent Type" name="type" id="type" required>
                            <option disabled selected> --- Select the type of role ---</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" @if(old('type') == $type) selected @endif>{{ $type }}</option>
                            @endforeach
                        </select>
                        <x-input-error :input-name="$error = 'type'" />
                    </div>
                </div>

                <div class="mt-6">
                    <label class="form-label text-primary font-semibold">Permissions</label>
                    <div class="grid grid-cols-10 gap-4">
                        @foreach($permissions as $permission)
                            <div class="md:col-span-3 xl:col-span-2 form-check mt-2">
                                <input id="{{str($permission->name)->slug()}}" class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                <label class="form-check-label" for="{{str($permission->name)->slug()}}">{{ ucwords($permission->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-right mt-10 pt-6 border-t">
                    <button type="reset" class="btn btn-outline-secondary w-24 mr-1">Reset</button>
                    <button type="submit" class="btn btn-primary w-24">Submit</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>

@endsection
