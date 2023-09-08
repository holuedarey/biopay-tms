<div class="pt-5 bg-white px-5 py-3" x-data>
    <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
        <p class="font-semibold">Showing list of {{ $name }} General Ledger Transactions</p>

        <x-table-filter :show-search="false" />
    </div>
    <div >
        <div class="intro-y overflow-auto mt-8 sm:mt-0">
            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                    <tr class="bg-gray-200">
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Impact Amount</th>
                        <th>Prev Balance</th>
                        <th>New Balance</th>

                        @if(is_null($gl))
                            <th >Service</th>
                        @endif

                        <th >Type</th>
                        <th >Info</th>
                        <th >Date</th>
                    </tr>
                </thead>

                <tbody>
                @if($glts->count() > 0)
                    @foreach($glts as $glt)
                        <tr class="intro-x">
                            <td class="whitespace-nowrap">
                                <a href="{{ $glt->user ? route('users.show', $glt->user) : '#' }}"
                                   class="tooltip text-blue-600"
                                   title="{{ $glt->user?->email }}"
                                >
                                    {{ ucwords($glt->user?->name) }}
                                </a>
                            </td>
                            <td class="text-dark">@money($glt->amount)</td>

                            <td class="text-info">@money($glt->impact_amount)</td>

                            <td class="text-slate-600">@money($glt->prev_balance)</td>

                            <td class="text-blue-600">@money($glt->new_balance)</td>

                            @if(is_null($gl))
                                <td>
                                    <x-badge :value="$glt->generalLedger->service->name" />
                                </td>
                            @endif

                            <td>
                                <span class="text-{{ statusColor($glt->type) }}-500">{{ $glt->type->value }}</span>
                            </td>

                            <td>{{ $glt->info }}</td>

                            <td>{{ $glt->created_at->toDateTimeString() }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr class="intro-x"><td colspan="8" class="text-center">No Transaction has impacted the General Ledger</td></tr>
                @endif
                </tbody>
            </table>
        </div>

        <div>
            {{ $glts->links() }}
        </div>
    </div>
</div>
