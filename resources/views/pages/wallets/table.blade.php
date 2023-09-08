<div class="mt-4 bg-white px-5 py-3">
    <div class="w-full flex sm:flex-row flex-col gap-2 justify-between items-center sm:w-auto mt-3 sm:mt-0 lg:ml-auto md:ml-0">
        <p class="font-semibold">Showing list of all wallets</p>
        <div class="md:w-72 sm:w-64 w-full relative text-slate-500">
            <input type="text" class="form-control w-full pr-10" wire:model.debounce.500ms="search"
                   placeholder="Search name, email account number..." aria-describedby="Search" aria-label="Search"
            >
            <span wire:ignore>
            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
        </span>
        </div>
    </div>
    <div x-data="{action: '', acc_no: '', name: ''}">
        <div class="intro-y overflow-auto mt-8 sm:mt-0">
            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                <tr class="bg-gray-200">
                    <th class="whitespace-nowrap">Name</th>
                    <th class="whitespace-nowrap">Role</th>
                    <th class="whitespace-nowrap">Account Number</th>
                    <th class="whitespace-nowrap">Balance</th>
{{--                    <th class="whitespace-nowrap">Income</th>--}}
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Date Created</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($wallets as $wallet)
                    <tr class="intro-x">
                        <td class="">
                            <a href="{{ route('users.show', $wallet->agent->id) }}"
                               class="tooltip text-blue-600" title="{{ $wallet->agent->email }}"
                            >
                                {{ ucwords($wallet->agent->name) }}
                            </a>
                        </td>

                        <td class=""><x-badge>@nbsp(ucwords($wallet->agent->roleName))</x-badge></td>

                        <td class="">{{ $wallet->account_number }}</td>

                        <td class="text-blue-600">@money($wallet->balance)</td>

{{--                        <td class="text-success">@money($wallet->income)</td>--}}

                        <td class=""><livewire:status-toggle-badge :model="$wallet" wire:key="wallet-{{$wallet->id}}" /></td>

                        <td class="">{{ $wallet->created_at->toDayDateTimeString() }}</td>
                        <td class="table-report__action w-48">
                            <div class="flex justify-around items-center">
                                <a href="#" data-tw-toggle="modal" data-tw-target="#impact-wallet"
                                   class="flex items-center text-info cursor-pointer"
                                   @click="action = '{{ route('wallets.update', $wallet) }}'; name = @js($wallet->agent->name); acc_no = @js($wallet->account_number)"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus-square" data-lucide="plus-square" class="lucide lucide-plus-square w-4 h-4 mr-1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Credit/Debit
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $wallets->links() }}
        </div>

        <div id="impact-wallet" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h2 class="font-medium text-base mr-auto">Credit/Debit Wallet for <span x-text="name"></span></h2>
                    </div>
                    <form method="post" :action="action" class="my-form">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')

                            <p class="mb-2">Account Number - <span class="font-medium" x-text="acc_no"></span></p>

                            <x-note message="The debit or credit impact on the wallet would require approval."/>

                            <div class="mt-3">
                                <label for="amount" class="form-label sm:w-56">Amount</label>
                                <div class="w-full">
                                    <input id="amount" name="amount" type="text" class="form-control" placeholder="0.00" />
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="action" class="form-label sm:w-56">Action</label>
                                <div class="w-full">
                                    <select id="action" name="action" class="form-control form-select" required>
                                        <option disabled selected>-- Select action --</option>
                                        <option value="{{ \App\Enums\Action::CREDIT }}">Credit</option>
                                        <option value="{{ \App\Enums\Action::DEBIT }}">Debit</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="info" class="form-label sm:w-56">Reason/Info</label>
                                <div class="w-full">
                                    <textarea name="info" id="info" class="form-control form-textarea" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN: Slide Over Footer -->
                        <div class="modal-footer w-full flex justify-end gap-4 absolute bottom-0">
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button type="submit" class="btn btn-primary w-20">Submit</button>
                        </div>
                        <!-- END: Slide Over Footer -->
                    </form>
                </div>
            </div>
        </div> <!-- END: Slide Over Content -->
    </div>
</div>
