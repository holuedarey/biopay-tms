@php($placeholder = ($type == 'all') ? 'name, email, reference, service' : ($type == 'wallet' ? 'name, email, reference, account number' : 'reference, service' ))

<div class="bg-white px-5 py-3" x-data="{route: null}">
    <div class="intro-y col-span-12 flex lg:flex-row flex-col flex-wrap sm:flex-nowrap gap-4 lg:items-end justify-between">
        <h4 class="font-medium lg:mr-auto">
            Showing list of all {{ $type == 'wallet' ? 'Wallet ' : '' }} transactions
        </h4>

        <x-table-filter :placeholder="$placeholder" />
    </div>
    <div class="bg-white">
        <div class="intro-y overflow-auto mt-8 sm:mt-0">
            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                <tr class="bg-gray-200">
                    @unless($type == 'single-user')
                        <th >Name</th>
                    @else
                        <th>Terminal</th>
                    @endunless

                    @if($type == 'wallet')
                        <th class="whitespace-nowrap">Account Number</th>
                    @endif

                    <th >Amount</th>

                    @if($type == 'wallet')
                        <th >Prev Balance</th>
                        <th >New Balance</th>
                        <th >Type</th>
                    @endif

                    @if(in_array($type, ['all', 'single-user']))
                        <th scope="col">Charge</th>
                        <th scope="col">Total</th>
                        <th scope="col">Service</th>
                        <th scope="col">Status</th>
                    @endif

                    @if($type == 'wallet')
                        <th >Reason</th>
                    @endif

                    <th >Reference</th>
                    <th >Info</th>
                    <th >Date</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($transactions as $transaction)
                    <tr class="intro-x">

                    @unless($type == 'single-user')
                            <td class="whitespace-nowrap">
                                <a href="{{ route('users.show', $transaction->agent) }}"
                                   class="tooltip text-blue-600"
                                   title="{{ $transaction->agent->email }}"
                                >
                                    {{ ucwords($transaction->agent->name) }}
                                </a>
                            </td>
                        @else
                            <td class="whitespace-nowrap">
                                {{ $transaction->terminal->device }} - {{ $transaction->terminal->tid }}
                            </td>
                        @endunless

                        @if($type == 'wallet')
                            <td class="">{{ $transaction->wallet->account_number }}</td>
                        @endif

                        <td class="text-info">@money($transaction->amount)</td>

                        @if($type == 'wallet')
                            <td class="text-slate-500">@money($transaction->prev_balance)</td>

                            <td class="text-blue-600">@money($transaction->new_balance)</td>

                            <td class="">
                                <span class="text-{{ statusColor($transaction->action) }}-500 font-medium">
                                    {{ $transaction->action }}
                                </span>
                            </td>
                        @endif

                        @if(in_array($type, ['all', 'single-user']))
                            <td class="text-slate-500">@money($transaction->charge)</td>

                            <td class="text-blue-600">@money($transaction->total_amount)</td>

                            <td class="whitespace-nowrap text-center">
                                <div class="text-center">
                                    <img src="{{ $transaction->service->icon }}" alt="Service icon"
                                         class="w-8 h-8"
                                    >
                                </div>
                            </td>

                            <td class="text-yellow-500">
                                <x-transactions.status :$transaction />
                            </td>
                        @endif

                        @if($type == 'wallet')
                            <td class="text-green-600">
                                <x-badge :value="$transaction->type" :color="statusColor($transaction->type)" />
                            </td>
                        @endif

                        <td class="">{{ $transaction->reference }}</td>

                        <td >
                            <div class="w-32 truncate tooltip" title="{{ $transaction->info }}">{{ $transaction->info }}</div>
                        </td>

                        <td class="whitespace-nowrap">{{ $transaction->created_at->toDayDateTimeString() }}</td>
                    </tr>
                @empty
                    <tr class="intro-x"><td colspan="9" class="text-center">No transactions</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $transactions->links() }}
        </div>
    </div>

    <x-transactions.update-modal />
</div>
