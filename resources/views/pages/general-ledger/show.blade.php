@extends('../layout/'.  config('view.menu-style'))

@section('title', 'General Ledger')

@php($name = $gl->service->name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>

    @if($gl->service_id == 1)
        <li class="breadcrumb-item active" aria-current="page">Main General Ledger</li>
    @else
        <li class="breadcrumb-item"><a href="{{ route('general-ledger.show') }}">Main General Ledger</a></li>
        <li class="breadcrumb-item"><a href="{{ route('general-ledger.others') }}">Other General Ledgers</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $name }} General Ledger</li>
    @endif

@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ $name }} General Ledger
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="{{ route('general-ledger.others') }}" class="btn btn-primary shadow-md mr-2">View Other Services</a>
            </div>
        </div>
    </section>

    <section>
        <div class="block lg:grid lg:grid-cols-3 xl:gap-10 lg:gap-5">
            <div class="report-box zoom-in mt-6">
                <div class="intro-y h-full box md:col-span-1 p-5 intro-x w-auto lg:w-full sm:w-96 w-auto">
                    <div class="flex flex-wrap gap-3">
                        <div class="mr-auto">
                            <div class="flex items-center leading-3">
                                <span class="pr-2">Available Balance</span>
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            </div>
                            <div class="relative text-2xl font-medium leading-5 pl-4 mt-3.5">
                                @money($gl->balance)
                            </div>
                        </div>
                        @can('edit general ledger')
                            <span class="flex items-center justify-center w-12 h-12 rounded-full bg-info bg-opacity-20 hover:bg-opacity-30  text-info cursor-pointer"
                                  data-tw-toggle="modal" data-tw-target="#modal{{$gl->id}}"
                            >
                                <x-icons.plus />
                            </span>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 grid grid-cols-2 xl:gap-10 md:gap-5 gap-2">
                <div class="report-box zoom-in mt-6">
                    <div class="box col-span-1 p-5 intro-x w-auto">
                        <div class="flex flex-wrap gap-3">
                            <div class="mr-auto sm:w-auto w-full">
                                <div class="flex items-center leading-3">
                                    <span class="pr-2 text-success">Total Credit</span>
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                </div>
                                <div class="text-dark relative truncate sm:text-2xl text-lg font-medium leading-5 md:pl-4 mt-3.5">
                                    @money($sum['CREDIT'] ?? 0)
                                </div>
                            </div>
                            <span class="sm:flex items-center justify-center hidden w-12 h-12 rounded-full bg-success bg-opacity-20 text-success">
                                <i data-lucide="corner-down-left"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="report-box zoom-in mt-6">
                    <div class="box col-span-1 p-5 intro-x w-auto">
                        <div class="flex flex-wrap gap-3 w-auto">
                            <div class="mr-auto sm:w-auto w-full">
                                <div class="flex items-center leading-3">
                                    <span class="pr-2 text-danger">Total Debit</span>
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                </div>
                                <div class="text-dark relative sm:text-2xl text-lg truncate font-medium leading-5 md:pl-4 mt-3.5">
                                    @money($sum['DEBIT'] ?? 0)
                                </div>
                            </div>
                            <span class="sm:flex items-center justify-center hidden w-12 h-12 rounded-full bg-danger bg-opacity-20 text-danger">
                            <i data-lucide="corner-right-up"></i>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12">
        <livewire:gl-table :name="$name" :gl="$gl" />
    </section>

    @can('edit general ledger')
        <x-gl-modal :gl="$gl" />
    @endcan
@endsection
