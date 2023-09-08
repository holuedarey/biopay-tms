@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminals')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Terminals</li>
@endsection

@section('subcontent')
    <livewire:terminals-table />
@endsection
