@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminals')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('terminals.index') }}">Terminals</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add New Terminal</li>
@endsection

@section('subcontent')
    <div class="intro-y mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Add New Terminal
        </h2>

        <p class="text-primary text-sm mt-5">Add a new terminal for the specified agent's email</p>
    </div>

    <div class="flex mt-5">
        <div class="intro-y w-full md:w-[650px] lg:w-[750px]">
            <!-- BEGIN: Form Layout -->
            <form class="intro-y box px-5 py-7" method="post" action="{{ route('terminals.store') }}">
                @csrf

                <div class="form-inline mt-6">
                    <label for="email" class="form-label sm:w-24">Email</label>
                    <div class="w-full">
                        <input id="email" type="email" class="form-control" placeholder="example@gmail.com" name="email" value="{{ old('email') ?? request('agent')}}">
                        <x-input-error input-name="email" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="device" class="form-label sm:w-24">Device</label>
                    <div class="w-full">
                        <input id="device" type="text" class="form-control" placeholder="Enter the device name" name="device" value="{{ old('device') }}">
                        <x-input-error input-name="device" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="terminal_id" class="form-label sm:w-24">Terminal ID</label>
                    <div class="w-full">
                        <input id="terminal_id" type="text" class="form-control" placeholder="Enter Terminal ID" name="tid" value="{{ old('tid') }}">
                        <x-input-error input-name="tid" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="merchant_id" class="form-label sm:w-24">Merchant ID </label>
                    <div class="w-full">
                        <input id="merchant_id" type="text" class="form-control" placeholder="Enter Merchant ID" name="mid" value="{{ old('mid') }}">
                        <x-input-error input-name="mid" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="serial_no" class="form-label sm:w-24">Serial</label>
                    <div class="w-full">
                        <input id="serial_no" type="text" class="form-control" placeholder="Enter the device serial number" name="serial" value="{{ old('serial') }}">
                        <x-input-error input-name="serial" />
                    </div>
                </div>
                <div class="text-right mt-10 pt-6 border-t">
                    <button type="reset" class="btn btn-outline-secondary w-24 mr-1">Reset</button>
                    <button type="submit" class="btn btn-primary w-24">Submit</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection
