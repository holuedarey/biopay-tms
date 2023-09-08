@extends('../layout/'.  config('view.menu-style'))

@section('title', 'Statistics')

@section('breadcrumbs')
    @if($user)
        <li class="breadcrumb-item"><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></li>
    @endif
    <li class="breadcrumb-item active"><a>Statistics</a></li>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="intro-y flex items-center justify-between">
                <div class="flex items-center gap-1">
                    <h2 class="text-lg font-medium truncate">
                        Statistics
                    </h2>
                    <a href="{{ route('statistics') }}" class="ml-auto mt-0.5 text-primary tooltip" title="Refresh">
                        <i data-lucide="refresh-ccw"  class="w-3 h-3"></i>
                    </a>
                </div>

                <div class="flex gap-2">
                    <form action="">
                        <select name="period" onchange="this.closest('form').submit()"
                                class="form-select w-32 bg-transparent border-black border-opacity-10 mx-auto sm:mx-0 px-3"
                        >
                            <option value="today" @selected(request('period') == 'today')>Today</option>
                            <option value="yesterday" @selected(request('period') == 'yesterday')>Yesterday</option>
                            <option value="week" @selected(request('period') == 'week')>This week</option>
                            <option value="month" @selected(request('period') == 'month')>This month</option>
                            <option value="year" @selected(request('period') == 'year')>This year</option>
                            <option value="all" @selected(request('period') == 'all')>Overall</option>
                        </select>
                    </form>

                    <form action="">
                        <div class="w-56">
                            <div class="relative w-full mx-auto">
                                <input type="text"
                                       name="date_filter"
                                       data-start-date="{{ str(request('date_filter'))->before(' -') }}"
                                       data-end-date="{{ str(request('date_filter', today()->toDateString()))->after('- ') }}"
                                       placeholder="Date Range"
                                       aria-label="Date range filter"
                                       data-auto-apply="no"
                                       data-request-on-apply="yes"
                                       class="datepicker form-control date-filter bg-transparent w-full"
                                />
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="calendar"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($user)
            <div class="col-span-12">
                <p>Showing statistics for <span class="font-medium">{{ $user->name }}</span> - <i>{{ $user->email }}</i></p>
            </div>
        @endif

        <div class="col-span-12">
            <livewire:statistics :user="$user" :period="request('period')" :date_range="request('date_filter')" />
        </div>
    </div>
@endsection

@push('script')

@endpush
