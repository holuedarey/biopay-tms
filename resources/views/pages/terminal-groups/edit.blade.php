@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminals')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('terminals.index') }}">Terminals</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Terminal</li>
@endsection

@section('subcontent')
    <div class="intro-y mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Edit Terminal
        </h2>

{{--        <p class="text-primary text-sm mt-5">Edit terminal for <strong class="text-info">{{ $terminal->agent->name . ' ~ ' . $terminal->agent->email }}</strong></p>--}}
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 sm:col-span-9 md:col-span-8 lg:col-span-7 xl:col-span-6">
            <!-- BEGIN: Form Layout -->
            <form class="intro-y box px-5 py-7" method="post" action="{{ route('terminal-groups.update', $group->id) }}">
                @csrf
                @method('PUT')
                <div class="form-inline mt-6">
                    <label for="name" class="form-label sm:w-24">Name</label>
                    <div class="w-full">
                        <input id="name" type="text" class="form-control" placeholder="Enter Group Name" name="name" value="{{ old('name') ?? $group->name }}">
                        <x-input-error input-name="name" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="info" class="form-label sm:w-24">Description</label>
                    <div class="w-full">
                        <input id="info" type="text" class="form-control" placeholder="Enter a description" name="info" value="{{ old('info') ?? $group->info }}">
                        <x-input-error input-name="info" />
                    </div>
                </div>

                <div class="text-right mt-10 pt-6 border-t">
                    <button type="submit" class="btn btn-primary w-24">Update</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection
