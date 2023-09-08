<div x-data="{approval: {}, approvalRoute: null}">

    <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center mt-5 intro-y">
        <p class="font-semibold">Showing list of all pending approvals for actions</p>
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5" x-data>
        <div class="overflow-x-auto scrollbar-hidden">

            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                <tr class="bg-gray-200">
                    <th scope="col">#</th>

                    <th scope="col">Resource</th>

                    <th scope="col" class="text-center">Action</th>

                    <th scope="col" class="whitespace-nowrap">Performed By</th>

                    <th scope="col" class="text-center">Date</th>

                    <th class="text-center whitespace-nowrap">
                        <span class="flex justify-center">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </span>
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach ($approvals as $approval)
                    <tr class="intro-x">
                        <td class="w-56">{{ $loop->iteration }}</td>

                        <td class="w-56">{{ $approval->resource }}</td>

                        <td class=""><x-badge :value="$approval->action" :color="statusColor($approval->action)" /></td>

                        <td class="whitespace-nowrap">{{ $approval->author->name ?? '' }}</td>

                        <td class="whitespace-nowrap">{{ $approval->created_at->toDayDateTimeString() }}</td>

                        <td class="table-report__action w-56">
                            <div class="flex justify-around items-center">
                                <button class="flex items-center mr-3 text-blue-600"
                                        data-tw-toggle="modal" data-tw-target="#view-approval"
                                        @click="approvalRoute = '{{ route('approvals.update', $approval) }}'; approval = @js($approval)"
                                >
                                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i> View details
                                </button>

                                {{--<form action="{{ route('approvals.update', $approval) }}" method="post" class="my-form">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" title="Approve"
                                            class="flex items-center text-success cursor-pointer tooltip spinner-dark"
                                    >
                                        <i data-lucide="thumbs-up" class="w-4 h-4 mr-1"></i>
                                    </button>
                                </form>

                                <form action="{{ route('approvals.destroy', $approval) }}" method="post" class="my-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Decline"
                                            class="flex items-center text-red-600 cursor-pointer tooltip spinner-dark"
                                    >
                                        <i data-lucide="thumbs-down" class="w-4 h-4 mr-1"></i>
                                    </button>
                                </form>--}}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $approvals->links() }}
        </div>
    </div>
    <!-- END: HTML Table Data -->

    <x-approvals.show-details />

</div>
