<x-badge :color="statusColor($user->status)" class="flex w-fit justify-between items-center pr-1">
    <span class="pr-1">{{ $user->status }}</span>

    @can('update', $user)
        {{--     Dropdown to change status --}}
        <span class="dropdown" data-tw-placement="bottom">
        <span class="dropdown-toggle cursor-pointer" data-tw-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 mx-1"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </span>
        <span class="dropdown-menu w-40">
         <ul class="dropdown-content text-purple-600">
             @foreach($statuses as $status)
                 @if($status != $user->status)
                     <li class="dropdown-item text-{{ statusColor($status) }}-600 cursor-pointer"
                         wire:click="updateStatus('{{$status}}')"
                     >
                         {{ $status }}
                     </li>
                 @endif
             @endforeach
         </ul>
        </span>
    </span>
    @endcan
</x-badge>
