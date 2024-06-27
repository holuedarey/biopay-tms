@extends('../layout/'.  config('view.menu-style'))

@section('title', 'GeneralLedger')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('general-ledger.show') }}">Main General Ledger</a></li>
    <li class="breadcrumb-item active" aria-current="page">Others</li>
@endsection

@section('subcontent')
    <section>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                General Ledgers
            </h2>
        </div>
    </section>

    <section class="mt-6" x-data>
        <div class="flex justify-between m-0 p-0">
            <span class="px-3">Balance by services</span>
            <i data-lucide="chevrons-right" class="w-4 h-4 inline"></i>
        </div>
        <div class="flex overflow-x-scroll mt-1 pb-10 hide-scroll-bar">
            <div class="flex flex-nowrap">
                @foreach($gls as $gl)
                    @php($route = route('general-ledger.show', ['service' => $gl->service->slug]))
                    <div class="report-box zoom-in inline-block px-2">
                        <div class="box w-80">
                            <div class="flex justify-between gap-3">
                                <a class="w-full p-5" href="{{ $route }}">
                                    <div class="text-dark text-opacity-70 text-xs flex font-medium items-center leading-3">
                                        <span class="pr-2 truncate">{{ $gl->service->name }}</span>
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    </div>
                                    <div class="text-dark relative text-xl font-medium leading-5 pl-4 mt-3.5">
                                        @money($gl->balance)
                                    </div>
                                </a>

                                @can('edit general ledger')
                                    <div class="p-5">
                                        <span class="flex items-center justify-center w-fit h-fit rounded-full p-3 bg-info bg-opacity-20 hover:bg-opacity-30 text-info cursor-pointer"
                                              data-tw-toggle="modal" data-tw-target="#modal{{$gl->id}}"
                                        >
                                            <x-icons.plus />
                                        </span>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>

                    @can('edit general ledger')
                        <x-gl-modal :gl="$gl" />
                    @endcan
                @endforeach
            </div>
        </div>
    </section>

    <section>
        <livewire:gl-table />
    </section>
@endsection
