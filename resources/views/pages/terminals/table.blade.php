<div x-data="service_menus">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            @if($group) {{ $group->name }} - @endif Terminals
        </h2>

        @can('create', \App\Models\Terminal::class)
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#create-terminal">Add New Terminal</button>
            </div>
        @endcan
    </div>

    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5" x-data>
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">

            <!--  Filter form  -->
            <form class="xl:flex sm:mr-auto" method="post" wire:submit.prevent="searchData">
                <div class="sm:flex items-center sm:mr-4">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                    <select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto" wire:model="search.field">
                        <template x-for="field in {{ $fields }}" :key="field.field">
                            <option :value="field.field" x-text="field.name" :selected="field.field == $wire.search.field"></option>
                        </template>
                    </select>
                </div>

                <div x-show="$wire.search.field != 'created_at'" class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0" x-transition>
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                    <select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" wire:model="search.operator">
                        <option x-show="$wire.search.field != 'id'" value="like">like</option>
                        <option value="=">=</option>
                        <option value="<">&lt;</option>
                        <option value="<=">&lt;=</option>
                        <option value=">">></option>
                        <option value=">=">>=</option>
                        <option value="!=">!=</option>
                    </select>
                </div>



                <div x-show="$wire.search.field !== 'created_at'" class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Value</label>
                    <input type="text" wire:model.defer="search.value" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Search...">
                </div>

                <div x-show="$wire.search.field === 'created_at'" class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0" x-transition>
                    <label id="date_range" class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Date Range</label>
                    <input type="text" wire:model.defer="search.value" class="datepicker form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" data-daterange="true" :component="$wire.component" autocomplete="off" />
                </div>



                <div class="mt-2 xl:mt-0">
                    <button id="tabulator-html-filter-go" type="submit" class="btn btn-primary w-full sm:w-16" >Go</button>
                    <a href="" id="tabulator-html-filter-reset" type="reset" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</a>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">

            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                <tr class="bg-gray-200">
                    <th scope="col">Agent</th>
                    <th scope="col" class="col cursor-pointer" wire:click="sortBy('device')"><span x-show="$wire.order.by === 'device'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; Device</th>
                    <th scope="col" class="col cursor-pointer whitespace-nowrap" wire:click="sortBy('tid')"><span x-show="$wire.order.by === 'tid'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; Terminal ID</th>
                    <th scope="col" class="col cursor-pointer whitespace-nowrap" wire:click="sortBy('mid')"><span x-show="$wire.order.by === 'mid'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; Merchant ID</th>
                    <th scope="col" class="col cursor-pointer" wire:click="sortBy('serial')"><span x-show="$wire.order.by === 'serial'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; Serial Number</th>
                    <th scope="col" class="col cursor-pointer" wire:click="sortBy('status')"><span x-show="$wire.order.by === 'status'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; Status</th>
                    <th scope="col" class="col cursor-pointer" wire:click.prevent="sortBy('created_at')"><span x-show="$wire.order.by === 'created_at'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; Created</th>

                    <th class="text-center whitespace-nowrap">
                            <span class="flex justify-center">
                                <i data-lucide="settings" class="w-5 h-5"></i>
                            </span>
                    </th>
                </tr>
                </thead>

                <tbody>
                @forelse ($terminals as $terminal)
                    <tr class="intro-x">
                        <td class="whitespace-nowrap">
                            <a href="{{ route('users.show', $terminal->agent->id) }}"
                               class="tooltip text-blue-600"
                               title="{{ $terminal->agent->email }}">
                                {{ ucwords($terminal->agent->name) }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap">{{ $terminal->device }}</td>

                        <td>{{ $terminal->tid }}</td>

                        <td>{{ $terminal->mid }}</td>

                        <td>{{ $terminal->serial }}</td>

                        <td><livewire:status-toggle-badge :model="$terminal" wire:key="{{$terminal->tid}}" /></td>

                        <td class="whitespace-nowrap">{{ $terminal->created_at->toDayDateTimeString() }}</td>

                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <button class="flex items-center mr-3 w-full text-info "
                                        data-tw-toggle="modal" data-tw-target="#menu-list"
                                        @click="initializeModal(@js($terminal->menus), '{{ route('terminals.menus.store', $terminal) }}', @js($terminal))"
                                >
                                    <span class="bg-info/20 text-info text-xs px-1.5 py-0.5 rounded-full mr-1">{{ $terminal->menus->count() }}</span>
                                    Menus
                                </button>
                                @can('update', $terminal)
                                    <button class="flex items-center mr-3 text-blue-600"
                                            data-tw-toggle="modal" data-tw-target="#edit-terminal"
                                            @click="terminal = @js($terminal); action = '{{ route('terminals.update', $terminal) }}';"
                                    >
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x"><td colspan="10" class="text-center">No Terminal has been added yet</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex mt-5">
            <div class="w-2/5">
                Page Size
                <select name="" id="" class="form-control w-20" wire:model="perPage" wire:change="changePerPage()">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
            </div>

            <div class="w-3/5">
                {{ $terminals->links() }}
            </div>
        </div>
    </div>

    @can('create', \App\Models\Terminal::class)
        <x-terminals.create :$group />
    @endcan

    <!-- END: HTML Table Data -->
    <x-terminals.edit />

    <x-terminals.menus />
</div>
