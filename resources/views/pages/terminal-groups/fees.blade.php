@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminal Groups')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('terminal-groups.index', $terminalGroup) }}">Terminal Groups</a></li>
    <li class="breadcrumb-item active" aria-current="page">Fees</li>
@endsection

@section('subcontent')
    @livewire('fees-table', ['groupId' => $terminalGroup->id])
@endsection

@push('script')
    @vite('resources/js/pages/fees.js')
@endpush
