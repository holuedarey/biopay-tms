<div wire:key="{{ $transaction->id }}">
    <x-badge :color="statusColor($transaction->status)" class="flex w-fit justify-between items-center pr-1">
        <span class="pr-1">{{ $transaction->status }}</span>

        @if($transaction->isPending())
            @can('update transactions')
                {{--     Dropdown to change status --}}
                <span class="dropdown" data-tw-placement="bottom">
                    <span class="dropdown-toggle cursor-pointer" data-tw-toggle="dropdown">
                        <x-dropdown-icon />
                    </span>
                    <span class="dropdown-menu w-40">
                     <ul class="dropdown-content text-purple-600">
                         <li class="dropdown-item text-{{ statusColor($status = \App\Enums\Status::SUCCESSFUL) }}-600"
                         >
                             <a href="#" class="w-full"
                                data-tw-toggle="modal"
                                data-tw-target="#success-transaction-modal"
                                @click="route = @js(route('transactions.update', $transaction))"
                             >{{ $status }}</a>
                         </li>

                         <li class="dropdown-item text-{{ statusColor($status = \App\Enums\Status::FAILED) }}-600">
                             <a href="#"  class="w-full"
                                data-tw-toggle="modal"
                                data-tw-target="#fail-transaction-modal"
                                @click="route = @js(route('transactions.update', $transaction))"
                             >{{ $status }}</a>
                         </li>
                     </ul>
                    </span>
                </span>
            @endcan
        @endif
    </x-badge>
</div>
