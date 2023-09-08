@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Wallet Transactions')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Wallet Transactions</li>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center">
        <h2 class="text-lg font-medium mr-auto">
            Wallet Transactions
        </h2>
    </div>

    <section class="mt-4">
        <livewire:transactions-table type="wallet"/>
    </section>
@endsection
