<div>

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Terminal Profiles
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @can('create', \App\Models\TerminalGroup::class)
                <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#create-groups">Add New Profile</button>
            @endcan
        </div>
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
                        <option x-show="$wire.search.field == 'name'" value="like">like</option>
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
                    <button id="tabulator-html-filter-reset" type="reset" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">

            <table class="table table-report table-auto table-hover sm:mt-2">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="col cursor-pointer" wire:click="sortBy('id')">
                            <span x-show="$wire.order.by === 'id'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; #
                        </th>

                        <th class="col cursor-pointer" wire:click="sortBy('name')">
                            <span x-show="$wire.order.by === 'name'" class="float-left text-gray-400">@if($this->order['direction'] == 'asc')&#9660 @else &#9650 @endif</span> &nbsp; NAME
                        </th>

                        <th class="col">INFO</th>

                        <th class="text-center whitespace-nowrap">VIEWS</th>

                        <th class="text-center whitespace-nowrap">
                                <span class="flex justify-center">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                </span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                @if($groups->count() > 0)

                    @foreach ($groups as $group)

                        <tr class="intro-x">
                            <td class="w-36">{{ $group->id }}</td>

                            <td class="w-36">{{ $group->name }}</td>

                            <td class="w-64 break-normal">{{ substr($group->info, 0, 50) }} @if(strlen($group->info) > 0)... @endif </td>

                            <td class="table-report__action w-40">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3 btn btn-sm btn-danger-soft" href="{{ route('terminal-groups.fees.index', $group) }}">
                                        <i data-lucide="dollar-sign" class="w-4 h-4 mr-1"></i> Fees
                                    </a>

                                    <a class="flex items-center btn btn-sm btn-secondary-soft" href="{{ route('terminal-groups.terminals.index', $group) }}">
                                        <i data-lucide="smartphone" class="w-4 h-4 mr-1"></i> Terminals
                                    </a>
                                </div>
                            </td>

                            <td class="table-report__action w-40">
                                <div class="flex justify-center items-center">
                                    @can('update', $group)
                                        <button class="flex items-center mr-3 text-blue-600" wire:click="edit({{ $group }})"><i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </button>
                                    @endcan

                                    @can('delete', $group)
                                        <button type="button" class="flex items-center text-danger" wire:click="delete({{ $group }})" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr class="intro-x"><td colspan="10" class="text-center">No Group has been added yet</td></tr>
                @endif
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
                {{ $groups->links() }}
            </div>
        </div>
    </div>
    <!-- END: HTML Table Data -->



    @include('pages.terminal-groups.slide-over')

</div>
