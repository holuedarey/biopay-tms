@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Loans')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Loans</li>
@endsection

@section('subcontent')

    <div class="intro-y flex sm:flex-row flex-col sm:items-center justify-between mt-8">
        <h2 class="text-lg font-medium">
            Loans
        </h2>
    </div>

    <section class="sm:my-10 my-5">
        <div class="grid grid-cols-12 gap-6 xl:-mt-5 2xl:-mt-8 -mb-10 z-40 2xl:z-10">
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: Users Table -->
                    <livewire:loans-table />
                    <!-- END: Users Table -->
                </div>
            </div>
        </div>
    </section>
@endsection
