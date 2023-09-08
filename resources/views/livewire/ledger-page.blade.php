<div x-data>
    <section>
        <div class="grid grid-cols-4 xl:gap-5 md:gap-5 gap-2">
            <div class="report-box zoom-in mt-6">
                <div class="box col-span-1 p-5 intro-x w-auto">
                    <div class="flex flex-wrap gap-3">
                        <div class="w-full">
                            <div class="flex justify-between items-center leading-3">
                                <span class="pr-2 text-success font-medium">Total Credit</span>
                                <span class="sm:flex items-center justify-center hidden w-6 h-6 rounded-full bg-success bg-opacity-20 text-success">
                                    <i data-lucide="corner-down-left" class="w-4 h-4"></i>
                                </span>
                            </div>
                            <div class="text-dark relative truncate sm:text-2xl text-lg font-medium leading-5 md:pl-1 mt-3.5">
                                @money($type['CREDIT'] ?? 0)
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="report-box zoom-in mt-6">
                <div class="box col-span-1 p-5 intro-x w-auto">
                    <div class="flex flex-wrap gap-3 w-auto">
                        <div class="w-full">
                            <div class="flex justify-between items-center leading-3">
                                <span class="pr-2 text-danger font-medium">Total Debit</span>
                                <span class="sm:flex items-center justify-center hidden w-6 h-6 rounded-full bg-danger bg-opacity-20 text-danger">
                                    <i data-lucide="corner-up-right" class="w-4 h-4"></i>
                                </span>
                            </div>
                            <div class="text-dark relative sm:text-2xl text-lg truncate font-medium leading-5 md:pl-1 mt-3.5">
                                @money($type['DEBIT'] ?? 0)
                            </div>
                        </div>
                        {{--<span class="sm:flex items-center justify-center hidden w-12 h-12 rounded-full bg-danger bg-opacity-20 text-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="10 9 15 4 20 9"></polyline><path d="M4 20h7a4 4 0 004-4V4"></path></svg>
                    </span>--}}
                    </div>
                </div>
            </div>

            {{--            Opening Balance--}}
            <div class="report-box zoom-in mt-6">
                <div class="box col-span-1 p-5 intro-x w-auto">
                    <div class="flex flex-wrap gap-3 w-auto">
                        <div class="mr-auto sm:w-auto w-full">
                            <div class="flex items-center leading-3">
                                <span class="pr-2 text-blue-600 py-1.5">Opening Balance</span>
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            </div>
                            <div class="text-success relative sm:text-2xl text-lg truncate font-medium leading-5 md:pl-1 mt-3.5">
                                @money($openingBalance)
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--            Closing Balance--}}
            <div class="report-box zoom-in mt-6">
                <div class="box col-span-1 p-5 intro-x w-auto">
                    <div class="flex flex-wrap gap-3 w-auto">
                        <div class="mr-auto sm:w-auto w-full">
                            <div class="flex items-center leading-3">
                                <span class="pr-2 text-blue-600 py-1.5">Closing Balance</span>
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            </div>
                            <div class="text-danger relative sm:text-2xl text-lg truncate font-medium leading-5 md:pl-1 mt-3.5">
                                @money($closingBalance)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12 bg-white px-5 py-3">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-end justify-between">
            <h4 class="font-medium mr-auto">
                Wallet transactions ledger
            </h4>

            <x-table-filter placeholder="by agent, service" />
        </div>
        <div >
            <div class="intro-y overflow-auto">
                <table class="table table-report table-auto table-hover sm:mt-2">
                    <thead>
                    <tr class="bg-gray-200">
                        <th scope="col">Email</th>
                        <th scope="col">Service</th>
                        <th scope="col" class="whitespace-nowrap">Prev Balance</th>
                        <th scope="col">New Balance</th>
                        <th scope="col">
                            <span class="text-{{ statusColor(\App\Enums\Action::DEBIT) }}-600">
                                DEBIT
                            </span>
                        <th scope="col">
                            <span class="text-{{ statusColor(\App\Enums\Action::CREDIT) }}-600">
                                Credit
                            </span>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($transactions->count() > 0)
                        @foreach ($transactions as $transaction)
                            <tr class="intro-x">
                                <td class="">{{ $transaction->agent->email }}</td>

                                <td class=""><x-badge>@nbsp($transaction->service->name)</x-badge></td>

                                <td class="text-slate-500">@money($transaction->prev_balance)</td>

                                <td class="text-blue-600">@money($transaction->new_balance)</td>

                                <td class="">
                                    <span class="text-danger">@if($transaction->isDebit()) @money($transaction->amount) @endif</span>
                                </td>

                                <td class="">
                                    <span class="text-success">@if($transaction->isCredit()) @money($transaction->amount) @endif</span>
                                </td>

                                <td class="whitespace-nowrap">{{ $transaction->created_at->toDayDateTimeString() }}</td>
                            </tr>
                        @endforeach

                    @else
                        <tr class="intro-x"><td colspan="10" class="text-center">No Transaction has been made yet</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <div>
                {{ $transactions->appends(request()->all())->links() }}
            </div>
        </div>
    </section>
</div>
