@props(['showSearch' => true, 'placeholder' => ''])

<div class="w-full flex sm:flex-row flex-col gap-2 sm:w-auto mt-3 sm:mt-0 lg:ml-auto md:ml-0">
    @if($showSearch)
        <div class="md:w-72 sm:w-64 w-full relative text-slate-500">
            <input type="text" class="form-control w-full pr-10" wire:model.debounce.500ms="search"
                   placeholder="Search {{ $placeholder }}..." aria-describedby="Search" aria-label="Search"
            >
            <span wire:ignore>
            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
        </span>
        </div>
    @endif

    <div class="sm:w-52 w-full">
        <div class="relative w-full mx-auto">
            <input type="text" class="datepicker form-control w-full" id="date_filter"
                   data-end-date="{{ today()->toDateString() }}" placeholder="Date Range"
                   wire:model="date" aria-label="Date range filter"
            />
            <span wire:ignore>
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="calendar"></i>
            </span>
        </div>
    </div>
    <button class="btn btn-primary" @click="$wire.filterDate($('#date_filter').val())">Apply</button>
    <button class="btn" @click="$wire.filterDate()">Clear</button>
</div>
