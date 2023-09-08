@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Ledger')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ledger</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Ledger
            </h2>
        </div>
    </section>

    <livewire:ledger-page />
@endsection
