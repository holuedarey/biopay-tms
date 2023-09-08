@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Wallets')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Wallets</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center">
            <h2 class="text-lg font-medium mr-auto">
                Wallets
            </h2>
        </div>
    </section>

    <livewire:wallets-table />
@endsection
