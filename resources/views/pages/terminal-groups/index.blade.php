@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminal Groups')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Terminal Profiles</li>
@endsection

@section('subcontent')
    @livewire('terminal-groups-table')
@endsection

@push('script')
    @vite('resources/js/pages/terminal-groups.js')
@endpush
