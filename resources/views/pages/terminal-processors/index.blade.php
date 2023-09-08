@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminal Processors')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Terminal-processors</li>
@endsection

@section('subcontent')
    <livewire:terminal-processors-table />
@endsection
