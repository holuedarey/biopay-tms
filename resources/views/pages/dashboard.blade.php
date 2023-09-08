@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a>Dashboard</a></li>
@endsection

@section('subcontent')
    <div class="relative">
        <div @class(['grid grid-cols-12 gap-6', 'xl:grid-cols-9' => Auth::user()->cannot('read general ledger')])>
            <div class="col-span-12 xl:col-span-9 2xl:col-span-9 z-10">
                <div class="mt-14 mb-3 grid grid-cols-12 sm:gap-10 intro-y">
                    <div class="col-span-12 md:col-span-8">
                        <livewire:transaction-statistics />
                    </div>
                    <div class="col-span-12 md:col-span-4 py-6 border-black border-opacity-10 border-t sm:border-t-0 border-l md:border-l-0 border-dashed -ml-4 pl-4 md:ml-0 md:pl-0">
                        <ul class="nav nav-pills w-3/4 2xl:w-4/6 bg-slate-200 dark:bg-black/10 rounded-md mx-auto p-1" role="tablist">
                            <li id="active-users-tab" class="nav-item flex-1" role="presentation">
                                <button
                                    class="nav-link info-color w-full py-1.5 px-2 active"
                                    data-tw-toggle="pill"
                                    data-tw-target="#active-users"
                                    type="button"
                                    role="tab"
                                    aria-controls="active-users"
                                    aria-selected="true"
                                >
                                    Active
                                </button>
                            </li>
                            <li id="inactive-users-tab" class="nav-item flex-1" role="presentation">
                                <button
                                    class="nav-link info-color w-full py-1.5 px-2"
                                    data-tw-toggle="pill"
                                    data-tw-target="#inactive-users"
                                    type="button"
                                    role="tab"
                                    aria-selected="false"
                                >
                                    Inactive
                                </button>
                            </li>
                        </ul>

                        @php
                            $sum = $terminals->active + $terminals->inactive;

                            if ( $sum > 0 ) {
                                $active_percent = round(($terminals->active/$sum) * 100, 2);
                                $inactive_percent = round(($terminals->inactive/$sum) * 100, 2);
                            }
                            else {
                                $active_percent = 0;
                                $inactive_percent = 0;
                            }
                        @endphp
                        <div class="relative">
                            <div class="my-5 text-center font-medium">Total - {{ $sum }}</div>
                            <div class="h-[215px]">
                                <canvas id="terminal-donut-chart-3"
                                        data-values="{{ json_encode([$terminals->inactive, $terminals->active]) }}"
                                        data-labels="{{ json_encode(['Inactive', 'Active']) }}"
                                ></canvas>
                            </div>
                            <div class="tab-content absolute top-1/2 left-1/2">
                                <div class="tab-pane active" id="active-users" role="tabpanel" aria-labelledby="active-users-tab">
                                    <div class="flex flex-col justify-center items-center absolute w-full h-full top-0 left-0">
                                        <div class="text-xl 2xl:text-2xl font-medium">{{ $terminals->active }}</div>
                                        <div class="text-slate-500 mt-0.5 whitespace-nowrap">Active Terminals</div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="inactive-users" role="tabpanel" aria-labelledby="active-users-tab">
                                    <div class="flex flex-col justify-center items-center absolute w-full h-full top-0 left-0">
                                        <div class="text-xl 2xl:text-2xl font-medium">{{ $terminals->inactive }}</div>
                                        <div class="text-slate-500 mt-0.5 whitespace-nowrap">Inactive Terminals</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mx-auto w-10/12 2xl:w-2/3 mt-8">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-success rounded-full mr-3"></div>
                                <span class="truncate">Active terminals</span>
                                <span class="font-medium ml-auto">{{ $active_percent }}%</span>
                            </div>
                            <div class="flex items-center mt-4">
                                <div class="w-2 h-2 bg-warning rounded-full mr-3"></div>
                                <span class="truncate"> Inactive Terminals</span>
                                <span class="font-medium ml-auto">{{ $inactive_percent }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('read general ledger')
            <div class="report-box-4 w-full h-full grid grid-cols-12 gap-6 xl:absolute -mt-8 xl:mt-0 pb-6 xl:pb-0 top-0 right-0 z-30 xl:z-auto">
                <div class="col-span-12 xl:col-span-3 xl:col-start-10 xl:pb-16 z-30">
                    <div class="h-full flex flex-col">
                        <div class="box p-5 mt-6 bg-primary intro-x">
                            <div class="flex flex-wrap gap-3">
                                <div class="mr-auto">
                                    <div class="text-white text-opacity-70 dark:text-slate-300 flex items-center leading-3">
                                        General Ledger Total Balance
                                        <i data-lucide="alert-circle" class="tooltip w-4 h-4 ml-1.5" title="Total value of your sales: ₦158.409.416"></i>
                                    </div>
                                    <div class="text-white flex justify-between gap-6 items-center text-2xl font-medium leading-5 mt-3.5">
                                        @money($gl_balance->total)
                                        <a class="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-darkmode-300 bg-opacity-20 hover:bg-opacity-30 text-white" href="">
                                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="report-box-4__content xl:min-h-0 intro-x">
                            <div class="max-h-full xl:overflow-y-auto box mt-5">
                                <div class="xl:sticky border-b bg-white top-0 px-5 pt-5 pb-3 mb-2">
                                    <div class="flex items-center">
                                        <div class="font-medium truncate mr-5">Balance Summary by Services</div>
                                    </div>
                                </div>
                                <div class="tab-content px-5 pb-5">
                                    <div class="tab-pane active grid grid-cols-12 gap-y-3" id="weekly-report" role="tabpanel" aria-labelledby="weekly-report-tab">
                                        <div class="col-span-12 sm:col-span-6 md:col-span-3 xl:col-span-12">
                                            <div class="text-slate-500">Cashout</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-lg">@money($gl_balance->cashout)</div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-3 xl:col-span-12">
                                            <div class="text-slate-500">Transfer</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-lg">@money($gl_balance->transfer)</div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-3 xl:col-span-12">
                                            <div class="text-slate-500">Airtime & Data</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-lg">@money($gl_balance->airtime_data)</div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 sm:col-span-6 md:col-span-3 xl:col-span-12">
                                            <div class="text-slate-500">Bill Payments</div>
                                            <div class="mt-1.5 flex items-center">
                                                <div class="text-lg">@money($gl_balance->bill_payments)</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('general-ledger.show') }}" class="btn btn-outline-secondary col-span-12 border-slate-300 dark:border-darkmode-300 border-dashed relative justify-start mb-2">
                                            <span class="truncate mr-5">View General Ledger</span>
                                            <span class="w-8 h-8 absolute flex justify-center items-center right-0 top-0 bottom-0 my-auto ml-auto mr-0.5">
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="report-box-3 report-box-3--content grid grid-cols-12 gap-6 xl:-mt-5 2xl:-mt-8 -mb-10 z-40 2xl:z-10">
        <div class="col-span-12 2xl:col-span-9">
            <div class="intro-y flex items-center">
                <h2 class="text-lg font-medium truncate mr-5">Latest Transactions</h2>
                <div class="flex items-center ml-auto">
                    <a href="{{ route('transactions.index') }}" class="underline text-primary hover:text-opacity-70 mr-4">View more</a>
                </div>
            </div>
            <div class="intro-y overflow-auto mt-5 sm:mt-0">
                <table class="table table-report table-auto table-hover sm:mt-2">
                    <thead>
                    <tr class="bg-gray-200">
                        <th >Name</th>
                        <th >Amount</th>
                        <th scope="col">Charge</th>
                        <th scope="col">Total</th>
                        <th scope="col">Service</th>
                        <th scope="col">Status</th>
                        <th >Reference</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($latest_transactions as $transaction)
                        <tr class="intro-x">
                            <td class="whitespace-nowrap">
                                <a href="{{ route('users.show', $transaction->agent->id) }}"
                                   class="tooltip text-blue-600"
                                   title="{{ $transaction->agent->email }}"
                                >
                                    {{ ucwords($transaction->agent->name) }}
                                </a>
                            </td>
                            <td class="text-info">@money($transaction->amount)</td>
                            <td class="text-slate-500">@money($transaction->charge)</td>
                            <td class="text-blue-600">@money($transaction->total_amount)</td>
                            <td class="">
                                <div class="text-center">
                                    <img src="{{ $transaction->service->icon }}" alt="Service icon"
                                         class="w-8 h-8"
                                    >
                                </div>
                            </td>
                            <td class="">
                                <span class="text-{{ statusColor($transaction->status) }}-500">{{ $transaction->status }}</span>
                            </td>
                            <td class="">{{ $transaction->reference }}</td>
                        </tr>
                    @empty
                        <tr class="intro-x"><td colspan="8" class="text-center">No transactions have been made</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-span-12 2xl:col-span-9">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">Recently added Agents</h2>
                <div class="flex items-center ml-auto">
                    <a href="{{ route('agents.index') }}" class="underline text-primary hover:text-opacity-70 mr-4">View all agents</a>
                </div>
            </div>
            <div class="intro-y overflow-auto mt-5 sm:mt-0">
                <table class="table table-report table-auto table-hover sm:mt-2">
                    <thead>
                    <tr class="bg-gray-200">
                        <th class="whitespace-nowrap"></th>
                        <th class="whitespace-nowrap">Name</th>
                        <th class="whitespace-nowrap">Email</th>
                        <th class="">Level</th>
                        <th class="">Status</th>
                        <th class="">Date Registered</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($agents as $agent)
                        <tr class="intro-x">
                            <td class="w-20">
                                <div class="flex">
                                    <div class="w-10 h-10 image-fit zoom-in">
                                        <x-user-avatar :user="$agent" class="rounded-full" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('users.show', $agent) }}" class="font-medium whitespace-nowrap">{{ $agent->name }}</a>
                            </td>
                            <td>{{ $agent->email }}</td>
                            <td><x-badge>{{ $agent->kycLevel->name }}</x-badge></td>
                            <td class="text-center whitespace-nowrap">
                                <livewire:user-status-badge :user="$agent" wire:key="status-badge-{{ $agent->id }}"/>
                            </td>
                            <td>{{ $agent->created_at->toDayDateTimeString() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @vite(['resources/js/pages/dashboard.js'])
@endpush
