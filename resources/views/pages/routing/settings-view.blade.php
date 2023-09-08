<div>

    <section>
        @error('item.min_amount')
        <div class="error-label">
            {{ $message }}
        </div>
        @enderror
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8 mb-4">
            <h2 class="text-lg font-medium mr-auto">
                {{ $type }} Settings
            </h2>

            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button type="button" wire:click="add()" class="col-span-1 btn btn-primary shadow-sm">Add New</button>
            </div>
        </div>
    </section>

    <section class="mt-3 bg-white px-5 py-3">
        <div x-data="{type: {}, action: null}">
            <div class="sm:mb-3 flex flex-col-reverse sm:flex-row justify-between sm:items-center intro-y">
                <p class="font-semibold">Showing list {{ $type }} settings</p>
            </div>
            <div >
                <div class="intro-y overflow-auto lg:overflow-visible">
                    <table class="table table-report table-auto table-hover sm:mt-2">
                        <thead>
                        <tr class="bg-gray-200">
                            <th class="col cursor-pointer" wire:click="sortBy('id')">
                                <span x-show="$wire.order.by === 'id'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; #
                            </th>
                            <th scope="col">Min Amount</th>
                            <th scope="col">Max Amount</th>
                            <th scope="col">Primary Processor</th>
                            <th scope="col">Secondary Processor</th>
                            <th scope="col">Created At</th>
                            <th class="text-center whitespace-nowrap">
                                <span class="flex justify-center">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                </span>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($items as $item)
                            <tr class="intro-x">
                                <td>{{ $item->id }}</td>

                                <td>@money($item->min_amount)</td>
                                <td>@money($item->max_amount)</td>

                                <td>{{ ucwords($item->primary) }}</td>
                                <td>{{ ucwords($item->secondary) }}</td>


                                <td>{{ $item->created_at->toDayDateTimeString() }}</td>

                                <td class="table-report__action w-40">
                                    <div class="flex justify-around gap-4 items-center">
                                        <button type="button" wire:click="edit({{ $item }})" class="flex items-center text-warning spinner-dark">
                                            <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                                        </button>

                                        <button type="button" wire:click="delete({{ $item }})" class="flex items-center text-danger spinner-dark">
                                            <i data-lucide="trash" class="w-4 h-4 mr-1"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    @include('pages.routing.slide-over')

</div>
