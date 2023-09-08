@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminals')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('terminals.index') }}">Terminals</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Terminal</li>
@endsection

@section('subcontent')
    <div class="intro-y mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Edit Terminal
        </h2>

        <p class="text-primary text-sm mt-5">Edit terminal for <strong class="text-info">{{ $terminal->agent->name . ' ~ ' . $terminal->agent->email }}</strong></p>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 sm:col-span-9 md:col-span-8 lg:col-span-7 xl:col-span-6">
            <!-- BEGIN: Form Layout -->
            <form class="intro-y box px-5 py-7" method="post" action="{{ route('terminals.update', $terminal->id) }}">
                @csrf
                @method('PUT')
                <div class="form-inline mt-6">
                    <label for="device" class="form-label sm:w-24">Device</label>
                    <div class="w-full">
                        <input id="device" type="text" class="form-control" placeholder="Enter the device name" name="device" value="{{ old('device') ?? $terminal->device }}">
                        <x-input-error input-name="device" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="terminal_id" class="form-label sm:w-24">Terminal ID</label>
                    <div class="w-full">
                        <input id="terminal_id" type="text" class="form-control" placeholder="Enter Terminal ID" name="tid" value="{{ old('tid') ?? $terminal->tid }}">
                        <x-input-error input-name="tid" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="merchant_id" class="form-label sm:w-24">Merchant ID </label>
                    <div class="w-full">
                        <input id="merchant_id" type="text" class="form-control" placeholder="Enter Merchant ID" name="mid" value="{{ old('mid') ?? $terminal->mid }}">
                        <x-input-error input-name="mid" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="serial_no" class="form-label sm:w-24">Serial</label>
                    <div class="w-full">
                        <input id="serial_no" type="text" class="form-control" placeholder="Enter the device serial number" name="serial" value="{{ old('serial') ?? $terminal->serial }}">
                        <x-input-error input-name="serial" />
                    </div>
                </div>
                <div class="text-right mt-10 pt-6 border-t">
                    <button type="submit" class="btn btn-primary w-24">Update</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection
