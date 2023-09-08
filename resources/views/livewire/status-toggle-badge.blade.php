<x-badge :color="statusColor($model->status)"
         class="flex w-fit justify-between pr-1 text-xs"
>
    <span class="pr-1.5">{{ $model->status }}</span>

    @can("edit {$model->getTable()}")
        @if($model->is_active)
            <span title="Suspend" class="tooltip pl-2 cursor-pointer"
                  wire:click="updateStatus"
            >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="toggle-right" data-lucide="toggle-right" class="lucide lucide-toggle-right block w-4 h-4 mx-auto"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="16" cy="12" r="3"></circle></svg>
        </span>
        @else
            <span title="Activate" class="pl-2 tooltip cursor-pointer"
                  wire:click="updateStatus"  wire:ignore
            >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="toggle-left" data-lucide="toggle-left" class="lucide lucide-toggle-left block w-4 h-4 mx-auto"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="8" cy="12" r="3"></circle></svg>
        </span>
        @endif
    @endcan
</x-badge>
