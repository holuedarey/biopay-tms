@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Manage Users')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route(strtolower($user->roleType) . '.index') }}">{{ $user->roleType }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $user->roleName }}</li>
@endsection

@section('subcontent')

    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $user->roleName }}
        </h2>
    </div>

    <div x-data="service_menus">
        <div x-data="{terminal: {}, action: null}">
            <!-- BEGIN: Profile Info -->
            <div class="grid grid-cols-10 gap-5 mt-5">
                <div class="col-span-12 lg:col-span-7">
                    <x-profile-card :user="$user" />
                </div>

                <div class="col-span-12 lg:col-span-3">
                    <div class="report-box h-full">
                        <div class="intro-y box p-5 h-full">
                            <div class="flex">
                                <i data-lucide="credit-card" class="text-success"></i>
                                <div class="ml-auto">
                                    <div class="report-box__indicator cursor-pointer">
                                        <livewire:status-toggle-badge :model="$user->wallet" />
                                    </div>
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-10">@money($user->wallet->balance)</div>
                            <div class="text-slate-500 mt-2 text-xs">Wallet Balance</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- END: Profile Info -->
            <div class="intro-y tab-content mt-10">
                <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
                    <div class="grid grid-cols-12 gap-6">

                        <!-- BEGIN: Transaction Details -->
                        <div class="intro-y box col-span-12 md:col-span-6">
                            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    Transaction Summary
                                </h2>
                                <div class="ml-auto">
                                    <a href="{{ route('statistics', $user) }}" class="text-xs text-primary hover:text-primary/70">View Statistics</a>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex flex-col sm:flex-row">
                                    <div class="mr-auto">
                                        <a href="" class="font-medium">@money($transactions->today->amount_sum)</a>
                                        <div class="text-slate-500 mt-1">Today</div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-32 -ml-2 sm:ml-0 mt-5 mr-auto sm:mr-5">
                                            <div class="h-[30px]">
                                                <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="bg-success/20 text-success rounded px-2 mt-1.5">{{ $transactions->today->count }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row mt-2">
                                    <div class="mr-auto">
                                        <a href="" class="font-medium">@money($transactions->week->amount_sum)</a>
                                        <div class="text-slate-500 mt-1">This week</div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-32 -ml-2 sm:ml-0 mt-5 mr-auto sm:mr-5">
                                            <div class="h-[30px]">
                                                <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="bg-info/20 text-info rounded px-2 mt-1.5">{{ $transactions->week->count }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row mt-2">
                                    <div class="mr-auto">
                                        <a href="" class="font-medium">@money($transactions->month->amount_sum)</a>
                                        <div class="text-slate-500 mt-1">This Month</div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-32 -ml-2 sm:ml-0 mt-5 mr-auto sm:mr-5">
                                            <div class="h-[30px]">
                                                <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="bg-pending/10 text-pending rounded px-2 mt-1.5">{{ $transactions->month->count }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row mt-2">
                                    <div class="mr-auto">
                                        <a href="" class="font-medium">@money($transactions->year->amount_sum)</a>
                                        <div class="text-slate-500 mt-1">This year</div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-32 -ml-2 sm:ml-0 mt-5 mr-auto sm:mr-5">
                                            <div class="h-[30px]">
                                                <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="bg-primary/10 text-primary rounded px-2 mt-1.5">{{ $transactions->year->count }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Transaction Details -->

                        <!-- BEGIN: KYC Details -->
                        <div class="intro-y box col-span-12 md:col-span-6">
                            <div class="flex items-center px-5 py-5 sm:py-0 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    KYC Details
                                </h2>
                                <div class="dropdown ml-auto sm:hidden">
                                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown">
                                        <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                                    </a>
                                    <div class="nav nav-tabs dropdown-menu w-40" role="tablist">
                                        <ul class="dropdown-content">
                                            <li> <a id="work-in-progress-mobile-new-tab" href="javascript:;" data-tw-toggle="tab" data-tw-target="#work-in-progress-new" class="dropdown-item" role="tab" aria-controls="work-in-progress-new" aria-selected="true">Terminals</a> </li>
                                            <li> <a id="work-in-progress-mobile-last-week-tab" href="javascript:;" data-tw-toggle="tab" data-tw-target="#work-in-progress-last-week" class="dropdown-item" role="tab" aria-selected="false">Level Info</a> </li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="nav nav-link-tabs w-auto ml-auto hidden sm:flex" role="tablist">
                                    <li id="terminal-tab" class="nav-item" role="presentation">
                                        <a href="javascript:;" class="nav-link py-5 active" data-tw-target="#terminal" aria-controls="terminal" aria-selected="true" role="tab">
                                            Terminal
                                            <span class="bg-primary/20 text-primary text-xs p-1 px-2 rounded-full">
                                                {{ $user->terminals->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li id="kyc-level-tab" class="nav-item" role="presentation">
                                        <a href="javascript:;" class="nav-link py-5" data-tw-target="#kyc-level" aria-selected="false" role="tab">
                                            Level
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="p-5">
                                <div class="tab-content">
                                    <div id="terminal" class="tab-pane active" role="tabpanel" aria-labelledby="terminal-tab">
                                        <div class="flex justify-between mb-1">
                                            <a href="#" class="btn btn-sm btn-outline-primary p-1"
                                               data-tw-toggle="modal" data-tw-target="#create-terminal"
                                            > Add Terminal </a>

                                            <div>
                                                <button data-carousel="terminals-slider" data-target="prev" class="tiny-slider-navigator btn p-1 border-slate-300 text-slate-600 dark:text-slate-300 mr-2">
                                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                                </button>
                                                <button data-carousel="terminals-slider" data-target="next" class="tiny-slider-navigator btn p-1 border-slate-300 text-slate-600 dark:text-slate-300 mr-2">
                                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @if($user->terminals->isNotEmpty())
                                            <div class="intro-y">
                                                <div class="box zoom-in">
                                                    <div class="tiny-slider" id="terminals-slider">
                                                        @foreach($user->terminals as $terminal)
                                                            <div class="p-4">
                                                                <div class="flex items-center">
                                                                    <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                                        <a href="" class="font-medium">{{ $terminal->tid }} :: {{ $terminal->device }}</a>
                                                                        <div class="text-slate-500">Terminal ID :: Device </div>
                                                                    </div>
                                                                    <div class="form-check form-switch ml-auto">
                                                                        <livewire:status-toggle-badge :model="$terminal" />
                                                                    </div>
                                                                </div>
                                                                <div class="flex items-center mt-5">
                                                                    <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                                        <a href="" class="font-medium">{{ $terminal->serial }}</a>
                                                                        <div class="text-slate-500">Serial Number</div>
                                                                    </div>
                                                                    <div class="ml-auto flex items-center gap-3">
                                                                        <a href="#" class="tooltip text-xs font-medium" title="Manage menus"
                                                                           data-tw-toggle="modal" data-tw-target="#menu-list"
                                                                           @click="initializeModal(@js($terminal->menus), '{{ route('terminals.menus.store', $terminal) }}', @js($terminal))"
                                                                        >
                                                                            <span class="bg-info/10 text-info px-2 p-1 shadow-sm hover:bg-info/20 rounded-full mr-1">{{ $terminal->menus->count() }} Menus</span>
                                                                        </a>

                                                                        @can('update', $terminal)
                                                                            <a href="#" class="tooltip" title="Edit Terminal Details"
                                                                               data-tw-toggle="modal" data-tw-target="#edit-terminal"
                                                                               @click="terminal = @js($terminal); action = '{{ route('terminals.update', $terminal) }}'"
                                                                            >
                                                                                <i data-lucide="edit" class="w-5 h-5 text-blue-600"></i>
                                                                            </a>
                                                                        @endcan
                                                                    </div>
                                                                </div>
                                                                <div class="flex items-center mt-5">
                                                                    <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                                        <a href="" class="font-medium">{{ $terminal->mid }}</a>
                                                                        <div class="text-slate-500">Merchant ID</div>
                                                                    </div>
                                                                    <div class="form-check form-switch ml-auto tooltip" title="Remove Terminal">
                                                                        <i data-lucide="trash-2" class="w-5 h-5 text-danger"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex justify-center items-center">
                                                This user has not been assigned any terminal.
                                            </div>
                                        @endif

                                    </div>

                                    <div id="kyc-level" class="tab-pane" role="tabpanel" aria-labelledby="kyc-level-tab">
                                        <div class="flex">
                                            <div class="mr-auto">
                                                <x-badge>{{ $user->kycLevel->name }}</x-badge>
                                            </div>
                                            <div>{{ $user->kycLevel->id }} / {{ app('levels')->count() }}</div>
                                        </div>
                                        <div class="progress h-1 mt-2">
                                            <div class="progress-bar w-{{ $user->level_id }}/4 bg-info" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="8"></div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="intro-x flex items-center h-10">
                                                <h2 class="text-sm font-medium truncate mr-auto">
                                                    Documents
                                                </h2>
                                                <div>
                                                    <button data-carousel="kyc-levels" data-target="prev" class="tiny-slider-navigator btn p-1 border-slate-300 text-slate-600 dark:text-slate-300 mr-2">
                                                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                                    </button>
                                                    <button data-carousel="kyc-levels" data-target="next" class="tiny-slider-navigator btn p-1 border-slate-300 text-slate-600 dark:text-slate-300 mr-2">
                                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="intro-y">
                                                <div class="box zoom-in">
                                                    <div class="tiny-slider" id="kyc-levels">

                                                        @if(!is_null($user->bvn))
                                                            <div class="p-4">
                                                                <div class="flex items-center">
                                                                    <div class="ml-4 mr-auto">
                                                                        <div class="font-medium">{{ $user->bvn }}</div>
                                                                        <div class="text-slate-500 text-xs mt-0.5">Bank verification number (BVN)</div>
                                                                    </div>
                                                                    <div class="py-1 px-2 text-xs text-dark focus:ring focus:border-slate-500 cursor-pointer font-medium">
                                                                        <i data-lucide="copy" class="w-5 h-5"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if(!is_null($user->nin))
                                                            <div class="p-4">
                                                                <div class="flex items-center">
                                                                    <div class="ml-4 mr-auto">
                                                                        <div class="font-medium">{{ $user->nin }}</div>
                                                                        <div class="text-slate-500 text-xs mt-0.5">National identification number (NIN)</div>
                                                                    </div>
                                                                    <div class="py-1 px-2 text-xs text-dark focus:ring focus:border-slate-500 cursor-pointer font-medium">
                                                                        <i data-lucide="copy" class="w-5 h-5"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @foreach($user->kycDocs as $doc)
                                                            <div class="p-4">
                                                                <div class="flex items-center">
                                                                    <div class="ml-4 mr-auto">
                                                                        <div class="font-medium">{{ $doc->name }}</div>
                                                                        <div class="text-slate-500 text-xs mt-0.5">{{ $doc->ext }}</div>
                                                                    </div>
                                                                    <div class="py-1 px-2 text-xs text-dark focus:ring focus:border-slate-500 cursor-pointer font-medium">
                                                                        <a href="{{ $doc->path }}" target="_blank" class="opacity-70">
                                                                            <i data-lucide="eye" class="w5 h-5"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        @if(is_null($user->nin) && is_null($user->bvn) && $user->kycDocs->isEmpty())
                                                            <div class="p-5 text-slate-500"> No document has been added...</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-center mt-4">
                                            <a href="{{ route('users.manage-level.index', $user->id) }}" class="btn btn-sm btn-secondary w-fit mx-2">Update Level & Docs</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: KYC Details -->
                    </div>

                    <div class="row">
                        @if($agents && $user->isSuperAgent())
                            <p class="mb-0 me-auto">Agent List</p>
                            <table class="table tab-content">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Phone</th>
                                    <th>Kyc Level</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @foreach($agents as $user)

                                    <tbody>
                                        <tr>
                                            <td><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></td>
                                            <td><a href="mailto:{{ $user->email }}" class="f-light">{{ $user->email }}</a></td>
                                            <td><a href="tel:{{ $user->phone }}" target="_blank"><i class="fa fa-phone"></i> {{ $user->phone }}</a></td>
                                            <td>{{ $user->kycLevel->name }}</td>
                                            <td><a href="{{ route('users.show', $user) }}" class="d-block"> View</a></td>
                                        </tr>
                                    </tbody>
                            @endforeach

                            </table>
                        @else
                            <p>No Associated Agent for this Terminal</p>
                        @endif

                    </div>
                    <!-- BEGIN: General Statistic -->
                    <section class="mt-12">
                        <livewire:transactions-table type="single-user" :user="$user" />
                    </section>
                    <!-- END: General Statistic -->
                </div>

                <x-terminals.edit />
                <x-terminals.menus />
                <x-terminals.create :$user />
            </div>
        </div>
    </div>
@endsection

