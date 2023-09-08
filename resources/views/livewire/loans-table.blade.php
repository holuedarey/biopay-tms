<div class="col-span-12 mt-6 bg-white px-5 py-3" x-data="{loanStatus: '', action: '#', loan: {}}">
    <p class="font-semibold py-2">Showing list of loan request from agents</p>

    <div class="intro-y overflow-auto sm:mt-0">
        <table class="table table-report table-auto table-hover">
            <thead>
            <tr class="bg-gray-200 uppercase">
                <th></th>
                <th class="whitespace-nowrap">Name</th>
                <th class="whitespace-nowrap">Request Amount</th>
                <th class="whitespace-nowrap">Amount</th>
                <th class="whitespace-nowrap">Status</th>
                <th class="whitespace-nowrap">Date requested</th>
                <th class="whitespace-nowrap">Date updated</th>
                <th class="text-center whitespace-nowrap">
                    <span class="flex justify-center">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                    </span>
                </th>
            </tr>
            </thead>
            <tbody>
            @if($loans->count() > 0)
                @foreach ($loans as $loan)
                    <tr class="intro-x">
                        <td class="w-20">
                            <div class="flex">
                                <div class="w-10 h-10 image-fit zoom-in">
                                    <x-user-avatar :user="$loan->agent" class="rounded-full" />
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap font-medium">
                            <a href="{{ route('users.show', $loan->agent) }}"
                               class="hover:opacity-70"
                            >
                                {{ $loan->agent->name }} <br>
                                <span class="text-slate-500 font-normal">{{ $loan->agent->email }}</span>
                            </a>
                        </td>

                        <td class="text-slate-600">@money($loan->amount)</td>

                        <td class="text-blue-600">@money($loan->transaction->amount)</td>

                        <td class="">
                            <x-loans.status-update-badge :$loan />
                        </td>

                        <td class="">{{ $loan->created_at->toDayDateTimeString() }}</td>

                        <td class="">{{ $loan->updated_at->toDayDateTimeString() }}</td>
                        <td class="table-report__action whitespace-nowrap">
                            <a href="#" class="text-info"
                               data-tw-toggle="modal" data-tw-target="#view-modal"
                               @click="loan = @js($loan->details())"
                            >View Details</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="9" class="text-center">No loan request.</td></tr>
            @endif
            </tbody>
        </table>
        <div>
            {{ $loans->links()}}
        </div>
    </div>

    <x-loans.status-update-modal />

    <x-loans.view />
</div>
