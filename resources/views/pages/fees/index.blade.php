@extends('../layout/'.  config('view.menu-style'))

@section('title', $title ?? "DEFAULT FEES")

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Fees</li>
@endsection

@section('subcontent')
    @livewire('fees-table')
@endsection
