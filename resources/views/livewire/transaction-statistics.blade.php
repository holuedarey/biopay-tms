<div class="grid grid-cols-12">
    <div class="col-span-12 md:col-span-6 py-1 sm:pl-1 md:pl-0 lg:pl-1 relative">
        <div class="text-lg 2xl:text-base font-medium -mb-1 text-center md:text-left">
            Hi {{ Auth::user()->first_name }}, <span class="text-slate-600 dark:text-slate-300 font-normal">welcome back! 👋🏼</span>
        </div>

        <div class="xl:min-h-0 intro-x md:w-60">
            <div class="max-h-full xl:overflow-y-auto box mt-5">
                <div class="xl:sticky border-b bg-white top-0 px-5 pt-5 pb-3 mb-2">
                    <div class="flex items-center">
                        <div class="w-full font-medium truncate">
                            <div class="w-full grid grid-cols-5">
                                <div class="col-span-2">Total</div>
                                <div class="col-span-3 text-right">
                                    {{$transactions->count}}
                                </div>
                            </div>
                            <p class="mt-2 text-2xl 2xl:text-3xl font-medium">@money($transactions->total)</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-y-3 p-5">
                    <div class="col-span-12">
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-slate-500">Cashout</div>
                            <div class="col-span-1 text-slate-500 text-right">Count</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-lg">
                                @money($services_stats->where('slug', 'cashoutwithdrawal')->first()?->amount ?? 0)
                            </div>

                            <div class="col-span-1 text-right">
                                {{ $services_stats->where('slug', 'cashoutwithdrawal')->first()?->count ?? 0 }}
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12">
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-slate-500">Transfer</div>
                            <div class="col-span-1 text-slate-500 text-right">Count</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-lg">
                                @money($services_stats->where('slug', 'banktransfer')->first()?->amount ?? 0)
                            </div>

                            <div class="col-span-1 text-right">
                                {{ $services_stats->where('slug', 'banktransfer')->first()?->count ?? 0}}
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-slate-500">BillPayment</div>
                            <div class="col-span-1 text-slate-500 text-right">Count</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-lg">
                                @money($services_stats->where('slug', 'electricity')->first()?->amount ?? 0 + $services_stats->where('slug', 'cabletv')->first()?->amount ?? 0)
                            </div>

                            <div class="col-span-1 text-right">
                                {{ $services_stats->where('slug', 'electricity')->first()?->count ?? 0 + $services_stats->where('slug', 'cabletv')->first()?->count ?? 0 }}
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-slate-500">Airtime</div>
                            <div class="col-span-1 text-slate-500 text-right">Count</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-lg">
                                @money($services_stats->where('slug', 'airtime')->first()?->amount ?? 0)
                            </div>

                            <div class="col-span-1 text-right">
                                {{ $services_stats->where('slug', 'airtime')->first()?->count ?? 0}}
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-slate-500">Data</div>
                            <div class="col-span-1 text-slate-500 text-right">Count</div>
                        </div>
                        <div class="grid grid-cols-5">
                            <div class="col-span-4 text-lg">
                                @money($services_stats->where('slug', 'internetdata')->first()?->amount ?? 0)
                            </div>

                            <div class="col-span-1 text-right">
                                {{ $services_stats->where('slug', 'internetdata')->first()?->count ?? 0 }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row-start-2 md:row-start-auto col-span-12 md:col-span-6 border-black border-opacity-10 border-t md:border-t-0 md:border-l md:border-r border-dashed px-10 sm:px-28 md:px-5 -mx-5 mt-5">

        <select wire:model="filter" class="form-select bg-transparent border-black border-opacity-10 dark:border-darkmode-400 dark:bg-transparent mx-auto sm:mx-0 px-3 w-full ">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="week">This week</option>
            <option value="month">This month</option>
            <option value="year">This year</option>
            <option value="">Overall</option>
        </select>

        <hr class="my-5">

        <div class="flex flex-wrap items-center">
            <div class="flex items-center w-full justify-center sm:justify-start mb-5 2xl:mb-0">
                <div class="w-2 h-2 bg-success rounded-full"></div>
                <div class="ml-3.5 flex items-center justify-between w-full">
                    <span class="mr-auto">Credit</span>
                    <span class="text-lg leading-6 top-0 font-medium left-0 2xl:-mt-1.5">@money($type['CREDIT'] ?? 0)</span>
                </div>
            </div>

            <div class="flex items-center w-full justify-center sm:justify-start mb-5 2xl:mb-0">
                <div class="w-2 h-2 bg-danger rounded-full"></div>
                <div class="ml-3.5 flex items-center justify-between w-full">
                    <span class="mr-auto">Debit</span>
                    <span class="text-lg leading-6 top-0 font-medium left-0 2xl:-mt-1.5">@money($type['DEBIT'] ?? 0)</span>
                </div>
            </div>
        </div>
        <div class="mt-4">
            @php($desc = empty($filter) ? 'Overall' : (in_array($filter, ['today', 'yesterday']) ? "$filter's" : "this $filter's"))

            <p class="p-1 px-2 rounded flex justify-center mb-2">Chart showing {{ $desc }} total transaction amount for each service.</p>
            <div class="h-[290px]">
                <canvas id="transactions-chart"
                        data-labels="{{ json_encode($services_stats->pluck('name')->toArray()) }}"
                        data-values="{{ json_encode($services_stats->pluck('amount')->toArray()) }}"
                ></canvas>
            </div>
        </div>
    </div>
</div>
