<div>

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ $title ?? 'Fees' }}
        </h2>
        {{--<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#create-fee">Add New Fee</button>
        </div>--}}
    </div>


    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">

        <div class="overflow-x-auto scrollbar-hidden">

            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                <tr class="bg-gray-200">
                    <th class="col">#</th>

                    <th scope="col">Title</th>

{{--                    <th scope="col">Service</th>--}}

                    <th scope="col">Group</th>

                    <th scope="col">Type</th>

                    <th scope="col">Amount</th>

                    <th scope="col">Amount Type</th>

                    <th scope="col">Cap</th>

                    <th scope="col">Config</th>

                    @can('edit fees')
                        <th class="text-center whitespace-nowrap">
                            <span class="flex justify-center">
                                <i data-lucide="settings" class="w-5 h-5"></i>
                            </span>
                        </th>
                    @endcan
                </tr>
                </thead>

                <tbody>
                @if($fees->count() > 0)

                    @foreach ($fees as $fee)
                        <tr class="intro-x">
                            <td class="w-auto">{{ $fee->id }}</td>
                            <td>{{ $fee->title }}</td>
{{--                            <td>{{ $fee->service->title }}</td>--}}
                            <td>{{ $fee->group->name }}</td>
                            <td>{{ $fee->type }}</td>
                            <td>{{ $fee->amount }}</td>
                            <td>{{ $fee->amount_type }}</td>
                            <td>{{ $fee->cap }}</td>

                            @if(empty($fee->config))
                                <td>N/A</td>
                            @else
                                <td class="w-auto">
                                    @foreach($fee->config as $range => $amount)
                                        <p>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ $range }}</span> => <span class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-800">₦{{ number_format($amount, 2) }}</span>
                                        </p>
                                    @endforeach
                                </td>
                            @endif


                            @can('update', $fee)
                                <td class="table-report__action w-40">
                                    <div class="flex justify-center items-center">
                                        <button class="flex items-center mr-3 text-primary" wire:click="edit({{ $fee }})"><i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </button>
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @endforeach

                @else
                    <tr class="intro-x"><td colspan="10" class="text-center">No Fee has been added yet</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- END: HTML Table Data -->


{{--    @include('pages.fees.slide-over')--}}

</div>
