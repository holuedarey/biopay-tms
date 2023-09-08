<div class="grid grid-cols-12 gap-4">
    @foreach($services as $service)
        <div class="col-span-12 mb-5 -mt-3">
            <div class="mb-3 flex justify-between items-center">
                <h4 class="font-medium text-xs">{{ $service->name }}</h4>
            </div>
            <div class="flex lg:block overflow-auto pb-5 pt-1.5 hide-scroll-bar">
                <div class="flex flex-nowrap lg:grid lg:grid-cols-3 gap-8">
                    <div class="report-box zoom-in w-60 md:w-72 lg:w-auto lg:col-span-1">
                        <div class="box p-5">
                            <div class="flex">
                                <img src="{{ $service->icon }}" class="report-box__icon" alt="">
                                <div class="ml-auto">
                                    <x-percentage-badge :value="$service->total_percent" />
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">{{ $service->total_trans }}</div>
                            <div class="text-base text-slate-500 mt-1">Total</div>
                        </div>
                    </div>
                    <div class="report-box zoom-in w-60 md:w-72 lg:w-auto lg:col-span-1">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-lucide="thumbs-up" class="report-box__icon text-success"></i>
                                <div class="ml-auto">
                                    <x-percentage-badge :value="$service->success_percent" />
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">{{ $service->successful }}</div>
                            <div class="text-base text-slate-500 mt-1">Successful</div>
                        </div>
                    </div>
                    <div class="report-box zoom-in w-60 md:w-72 lg:w-auto lg:col-span-1">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-lucide="thumbs-down" class="report-box__icon text-danger"></i>
                                <div class="ml-auto">
                                    <x-percentage-badge :value="$service->failed_percent" />
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">{{ $service->failed }}</div>
                            <div class="text-base text-slate-500 mt-1">Failed</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Response codes for cashout --}}
            @if($service->slug == 'cashoutwithdrawal' && $transactions->isNotEmpty())
                <h5 class="font-medium text-[12px] pt-1">Response Codes</h5>
                <div class="flex lg:block overflow-auto pb-5 pt-1.5 hide-scroll-bar">
                    <div class="flex flex-nowrap gap-5">
                        @foreach($transactions as $transaction)
                            <div class="zoom-in w-52">
                                <div class="box px-5 py-2">
                                    <div class="flex items-center">
                                        <div class="{{ $transaction->response_code == '00' ? 'text-success' : 'text-danger' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="database" data-lucide="database" class="lucide lucide-database w-4 h-4"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                                        </div>
                                        <span class="px-1 text-sm text-slate-500">{{ $transaction->response_code }}</span>
                                    </div>
                                     <p class="font-medium text-xl pt-1">{{ $transaction->count }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
