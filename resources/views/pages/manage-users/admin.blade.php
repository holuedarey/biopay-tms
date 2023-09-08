@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Manage Users')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Admins</li>
@endsection

@section('subcontent')

    <div class="intro-y flex sm:flex-row flex-col sm:items-center justify-between mt-8">
        <h2 class="text-lg font-medium">
            Administration
        </h2>

        @can('create', \App\Models\User::class)
            <a href="{{ route('admins.register') }}" class="btn btn-primary sm:mt-0 mt-5 text-left">Register New Admin</a>
        @endcan
    </div>

    <section class="sm:my-10 my-5">
        <div class="grid grid-cols-12 gap-6 xl:-mt-5 2xl:-mt-8 -mb-10 z-40 2xl:z-10">
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-6">

                    <!-- BEGIN: Users Table -->
                    <livewire:users-table name="admins" :show-level="false"/>
                    <!-- END: Users Table -->
                </div>
            </div>
        </div>
    </section>
@endsection
