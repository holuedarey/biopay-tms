@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Terminals')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('terminal-groups.fees.index', $group) }}">Fees</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Fee</li>
@endsection

@section('subcontent')
    <div class="intro-y mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Edit Fee for {{ $fee->title }}
        </h2>

{{--        <p class="text-primary text-sm mt-5">Edit terminal for <strong class="text-info">{{ $terminal->agent->name . ' ~ ' . $terminal->agent->email }}</strong></p>--}}
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 sm:col-span-9 md:col-span-8 lg:col-span-7 xl:col-span-6">
            <!-- BEGIN: Form Layout -->
            <form class="intro-y box px-5 py-7 my-form" method="post" action="{{ route('fees.update', $fee) }}">

                <h3>Group Name: <b>{{ $group->name }}</b></h3>
                <hr>

                @csrf
                @method('PUT')
                <div class="form-inline mt-6">
                    <label for="amount" class="form-label sm:w-24">Amount</label>
                    <div class="w-full">
                        <input id="amount" type="number" class="form-control" placeholder="Enter Amount" name="amount" value="{{ old('amount') ?? $fee->amount }}" step="any">
                        <x-input-error input-name="amount" />
                    </div>
                </div>

                <div class="form-inline mt-6">
                    <label for="amount_type" class="form-label sm:w-24">Amount Type</label>
                    <div class="w-full">
                        <select id="amount_type" class="form-control" name="amount_type">
                            <option value="PERCENTAGE" @if($fee->amount_type == 'PERCENTAGE') selected @endif>PERCENTAGE</option>
                            <option value="FIXED" @if($fee->amount_type == 'FIXED') selected @endif>FIXED</option>
                        </select>

                        <x-input-error input-name="amount_type" />
                    </div>
                </div>

                <div class="form-inline mt-6">
                    <label for="cap" class="form-label sm:w-24">Capped At</label>
                    <div class="w-full">
                        <input id="cap" type="number" class="form-control" placeholder="Capped" name="cap" value="{{ old('cap') ?? $fee->cap }}">
                        <x-input-error input-name="cap" />
                    </div>
                </div>
                <div class="form-inline mt-6">
                    <label for="info" class="form-label sm:w-24">Description</label>
                    <div class="w-full">
                        <input id="info" type="text" class="form-control" placeholder="Enter a description" name="info" value="{{ old('info') ?? $fee->info }}">
                        <x-input-error input-name="info" />
                    </div>
                </div>

                <hr class="mt-5">

                <div id="band-config">
                    <h2 class="mt-5">
                        Bands Configurations
                        <button type="button" class="add float-right btn border-t-teal-500 bg-teal-600 text-white btn-sm">+ Add</button>
                    </h2>
                    <div class="form-inline mt-6">
                        <h2 class="sm:w-56">Range</h2>
                        <h2>Amount/Charge</h2>
                    </div>
                    <div class="form">
                        @foreach( $fee->config as $key => $item )
                            <div class="form-inline mt-6">
                                <input type="text" class="form-control sm:w-48" value="{{ $key }}">
                                <p class="sm:w-16 text-center"> ==> </p>
                                <div class="w-full">
                                    <input type="text" class="form-control" name="config[{{$key}}]" value="{{ $item }}">
                                </div>

                                <button type="button" class="delete text-danger m-2">delete</button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end mt-10 pt-6 border-t">
                    <button type="submit" class="btn btn-primary w-24">Update</button>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection

<script type="module">
    (function () {

        var waitForJQuery = setInterval(function () {
            if (typeof $ != 'undefined') {

                edit();

                clearInterval(waitForJQuery);
            }
        }, 10);
    })();

    function edit() {
        var bandConfig = $('#band-config');

        bandConfig.find('.add').on('click', function (e) {
            e.preventDefault();

            var html = '<div class="form-inline mt-6"><input type="text" class="form-control sm:w-48" placeholder="Amount Range" name="newConfig[]"> <p class="sm:w-16 text-center"> ==> </p> <div class="w-full"> <input type="text" class="form-control" name="newConfig[]" placeholder="Charge"> </div> <button type="button" class="delete text-danger m-2">delete</button> </div>'

            bandConfig.find('.form').append(html)
        })

        bandConfig.find('.delete').on('click', function (e) {
            e.preventDefault()

            if ( confirm("Are you sure you want to delete?") ) {
                $(this).parent('div').remove();
            }
        })
    }
</script>
