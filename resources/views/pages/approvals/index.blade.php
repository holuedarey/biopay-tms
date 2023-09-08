@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Pending Approvals')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pending Approvals</li>
@endsection

@section('subcontent')
    <div>
        <h2 class="text-lg font-medium">Pending Approvals</h2>

        <livewire:approvals-table />
    </div>

@endsection

@if($errors->any())
    @push('script')
        @vite('resources/js/pages/validation-slider.js')
    @endpush
@endif


