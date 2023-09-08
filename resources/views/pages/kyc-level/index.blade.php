@extends('../layout/'.  config('view.menu-style'))

@section('title', 'KYC Level')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">KYC Level</li>
@endsection

@section('subcontent')
    <div x-data="{level: {}, action: null}">
        <section>
            <div class="intro-y flex sm:flex-row flex-col sm:items-center justify-between mt-8">
                <h2 class="text-lg font-medium">
                    KYC Level
                </h2>

                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#create-kyc-level" class="btn btn-primary sm:mt-0 mt-5 text-left" id="create-modal" @click="console.log('hi')">Add New Level</a>
            </div>
        </section>

        <section class="mt-8 bg-white px-5 py-3">
            <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
                <p class="font-semibold">Showing list of all KYC Level</p>
            </div>
            <div >
                <div class="intro-y overflow-auto lg:overflow-visible">
                    <table class="table table-report table-auto table-hover sm:mt-2">
                        <thead>
                        <tr class="bg-gray-200">
                            <th scope="col">#</th>

                            <th scope="col">Name</th>

                            <th scope="col">Daily Limit</th>

                            <th scope="col">Single Transaction Max</th>

                            <th scope="col">Maximum Balance</th>

                            <th class="text-center whitespace-nowrap">
                                <span class="flex justify-center">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                </span>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach (app('levels') as $level)
                            <tr class="intro-x">
                                <td class="w-56">{{ $level->id }}</td>

                                <td class="w-56">{{ $level->name }}</td>

                                <td class=""><span class="text-info">@money($level->daily_limit)</span></td>

                                <td class=""><span class="text-pending">@money($level->single_trans_max)</span></td>

                                <td class=""><span class="text-dark">@money($level->max_balance)</span></td>

                                <td class="table-report__action w-48">
                                    <div class="flex justify-around items-center">
                                        <a href="#edit-kyc-level" data-tw-toggle="modal" data-tw-target="#edit-kyc-level" class="flex items-center text-blue-600 cursor-pointer"
                                              @click="level = @js($level); action = '{{ route('kyc-levels.update', $level)}}'"
                                        >
                                            <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!--- Modals -->
        <!-- BEGIN: Slide Over Content -->
        <x-kyc-level.create-modal />
        <x-kyc-level.edit-modal />
    </div>

@endsection

@if($errors->any())
    @push('script')
        @vite('resources/js/pages/validation-slider.js')
    @endpush
@endif


