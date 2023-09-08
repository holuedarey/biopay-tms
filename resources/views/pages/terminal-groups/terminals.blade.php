@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminal Groups')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('terminal-groups.index') }}">Terminal Groups</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $terminalGroup->name }} - Terminals</li>
@endsection

@section('subcontent')
    @livewire('terminals-table', ['group' => $terminalGroup])
@endsection
