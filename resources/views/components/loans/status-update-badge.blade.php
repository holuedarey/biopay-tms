<x-badge :color="statusColor($loan->status)" class="flex w-fit justify-between items-center pr-1">
    <span class="pr-1">{{ $loan->status }}</span>
    @unless($loan->isRepaid() || $loan->isDeclined())
        <div class="dropdown" data-tw-placement="bottom">
            <div class="dropdown-toggle cursor-pointer" data-tw-toggle="dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3 mx-1">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    @php($status = \App\Enums\Status::APPROVED)
                    @if($loan->isPending())
                        <li class="dropdown-item text-{{ $color = statusColor($status) }}-600 cursor-pointer">
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#status-update-modal"
                               @click="loanStatus = '{{  $status->value }}'; action = '{{ route('loans.update', $loan) }}'"
                            >
                                APPROVE
                            </a>
                        </li>
                    @endif

                    @php($status = \App\Enums\Status::CONFIRMED)
                    @if(Auth::user()->can('approve loans') && $status != $loan->status)
                        @unless($loan->isDeclined() || $loan->isRepaid())
                            <li class="dropdown-item text-{{ $color = statusColor($status) }}-600 cursor-pointer">
                                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#status-update-modal"
                                   @click="loanStatus = '{{  $status->value }}'; action = '{{ route('loans.update', $loan) }}'"
                                >
                                    CONFIRM
                                </a>
                            </li>
                        @endunless
                    @endif

                    @php($status = \App\Enums\Status::DECLINED)
                    @if($loan->status != \App\Enums\Status::REPAID || $status != $loan->status)
                        <li class="dropdown-item text-{{ $color = statusColor($status) }}-600 cursor-pointer">
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#status-update-modal"
                               @click="loanStatus = '{{  $status->value }}'; action = '{{ route('loans.update', $loan) }}'"
                            >
                                DECLINE
                            </a>
                        </li>
                    @endif

                    @php($status = \App\Enums\Status::REPAID)
                    @if($loan->status != \App\Enums\Status::DECLINED || $status != $loan->status)
                        <li class="dropdown-item text-{{ $color = statusColor($status) }}-600 cursor-pointer">
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#status-update-modal"
                               @click="loanStatus = '{{  $status->value }}'; action = '{{ route('loans.update', $loan) }}'"
                            >
                                REPAID
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endunless
</x-badge>
