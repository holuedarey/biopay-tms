@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Amount Routing Settings')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $type }} Settings</li>
@endsection

@section('subcontent')
    @livewire('routing-settings-table', ['type' => $type, 'processors' => $processors])
@endsection

@push('script')
    @vite('resources/js/pages/routing-settings.js')
@endpush
