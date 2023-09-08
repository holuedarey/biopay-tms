<!-- BEGIN: Add Fee -->
    <div id="create-fee" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"
                x-data="{groups: [], services: []}"
                 x-init="
{{--                    groups = await (await fetch('{{ route('terminal-groups.json') }}')).json();--}}
{{--                    services = await (await fetch('{{ route('services.json') }}')).json()--}}
                    ">

                <span x-init="console.log(groups)"></span>

                <form method="post" action="{{ route('fees.store') }}">
                    <!-- BEGIN: Slide Over Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">
                            Add Fee
                        </h2>

                    </div>
                    <!-- END: Slide Over Header -->
                    <!-- BEGIN: Slide Over Body -->
                    <div class="modal-body">

                        <div class="mb-5">
                            <label for="group_id" class="form-label">Select Terminal Group</label>
                            <div class="w-full">
                                <select id="group_id" class="form-control" name="group_id">
                                    <template x-for="group in groups">
                                        <option :value="group.id" x-text="group.name"></option>
                                    </template>
                                </select>
                                
                                <x-input-error input-name="group_id" />
                            </div>
                        </div>


                        <div class="mb-5">
                            <label for="service_id" class="form-label">Select Service</label>
                            <div class="w-full">
                                <select id="service_id" class="form-control" name="service_id">
                                    <template x-for="service in services">
                                        <option :value="service.id" x-text="service.name"></option>
                                    </template>
                                </select>

                                <x-input-error input-name="service_id" />
                            </div>
                        </div>


                        <div class="mb-5">
                            <label for="title" class="form-label">Title</label>
                            <div class="w-full">
                                <input id="title" type="text" class="form-control" placeholder="Enter Fee Title" name="name" value="{{ old('title') }}">
                                <x-input-error input-name="title" />
                            </div>
                        </div>


                        <div class="mb-5">
                            <label for="type" class="form-label">Select Fee Type</label>
                            <div class="w-full">
                                <select id="type" class="form-control" name="type">
                                    <option value="CHARGE">CHARGE</option>
                                    <option value="COMMISSION">COMMISSION</option>
                                </select>

                                <x-input-error input-name="type" />
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="amount" class="form-label">Amount</label>
                            <div class="w-full">
                                <input id="amount" type="text" class="form-control" placeholder="Enter Fee amount" name="amount" value="{{ old('amount') }}">
                                <x-input-error input-name="amount" />
                            </div>
                        </div>


                        <div>
                            <label for="info" class="form-label">Description</label>
                            <div class="w-full">
                                <input id="info" type="text" class="form-control" placeholder="Add a bit of info about this group" name="info" value="{{ old('info') }}">
                                <x-input-error input-name="info" />
                            </div>
                        </div>
                    </div>
                    <!-- END: Slide Over Body -->
                    <!-- BEGIN: Slide Over Footer -->
                    <div class="modal-footer w-full absolute bottom-0">
                        <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" class="btn btn-primary w-20">Submit</button>
                    </div>
                    <!-- END: Slide Over Footer -->

                </form>
            </div>
        </div>
    </div>
<!-- END: Create Groups -->


<!-- BEGIN: Edit Groups -->
<div id="edit-group" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
{{--            <form method="post" action="">--}}
            <form method="post" wire:submit.prevent="update">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Update Terminal Group
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">

                    <div class="mb-5">
                        <label for="name" class="form-label">Name</label>
                        <div class="w-full">
                            <input type="text" class="form-control" wire:model="group.name">
                            <x-input-error input-name="name" />
                        </div>
                    </div>

                    <div>
                        <label for="info" class="form-label">Description</label>

                        <div class="w-full">
                            <textarea name="info" class="form-control" cols="30" rows="10" wire:model="group.info"></textarea>
                            <x-input-error input-name="info" />
                        </div>
                    </div>

                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div class="modal-footer w-full absolute bottom-0">

                    <button wire:loading wire:target="update" class="w-20 mr-1 action-loader">
                        <svg width="25" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="rgb(30, 41, 59)" class="w-8 h-8">
                            <circle cx="15" cy="15" r="15">
                                <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                            </circle>
                            <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
                                <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
                            </circle>
                            <circle cx="105" cy="15" r="15">
                                <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                            </circle>
                        </svg>
                    </button>


                    @if($message != '')<button class="w-20 mr-1 action-loader text-success">{{ $message }}</button>@endif


                    <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-20">Update</button>
                </div>
                <!-- END: Slide Over Footer -->

            </form>
        </div>
    </div>
</div>
<!-- END: Edit Groups -->

<!-- BEGIN: Edit Fee -->
<div id="edit-fee" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" x-data>

{{--            <p class="p-5" x-init="console.log(fee)"></p>--}}
{{--            <p>{{ $fee }}</p>--}}

            <form method="post" wire:submit.prevent="update">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Update Fee
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">

                    <div class="mb-5">
                        <label for="name" class="form-label">Amount</label>
                        <div class="w-full">
                            <input type="number" class="form-control" wire:model="fee.amount">
                            <x-input-error input-name="amount" />
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="name" class="form-label">Amount Type</label>
                        <div class="w-full">
                            <select class="form-control" wire:model="fee.amount_type">
                                <option value="PERCENTAGE" @if($fee->amount_type == 'PERCENTAGE') selected @endif>PERCENTAGE</option>
                                <option value="FIXED" @if($fee->amount_type == 'FIXED') selected @endif>FIXED</option>
                            </select>
                            <x-input-error input-name="amount_type" />
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="name" class="form-label">Capped At</label>
                        <div class="w-full">
                            <input type="number" class="form-control" wire:model="fee.cap">
                            <x-input-error input-name="cap" />
                        </div>
                    </div>

                    <div>
                        <label for="info" class="form-label">Description</label>

                        <div class="w-full">
                            <textarea name="info" class="form-control" cols="3" rows="2" wire:model="fee.info"></textarea>
                            <x-input-error input-name="info" />
                        </div>
                    </div>


                    <div class="mt-5">
                        <label for="name" class="form-label">Config/Bands</label>
                        <template x-for="(item, key) in $wire.fee.config">
                            <div class="w-full grid grid-flow-row-dense grid-cols-5 grid-rows-5">
{{--                                <div x-text="key" class="d-flex align-items-center justify-content-center"></div>--}}
                                <input type="text" class="form-control col-span-3" wire:model="fee.config[key]" x-value="key">
                                <div> ===> </div>
                                <input type="number" class="form-control col-span-3" wire:model="fee.config[item]">
                            </div>
                        </template>
{{--                        @foreach($fee->config as $key => $band)--}}
{{--                            <div class="w-full">--}}
{{--                                <div class="w-40" x-text="key"></div>--}}
{{--                                </span>: <input type="number" class="form-control" wire:model="fee.config[{{ $key }}]">--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
                    </div>

                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div class="modal-footer w-full absolute bottom-0">

                    <button wire:loading wire:target="update" class="w-20 mr-1 action-loader">
                        <svg width="25" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="rgb(30, 41, 59)" class="w-8 h-8">
                            <circle cx="15" cy="15" r="15">
                                <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                            </circle>
                            <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
                                <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
                            </circle>
                            <circle cx="105" cy="15" r="15">
                                <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                            </circle>
                        </svg>
                    </button>


                    @if($message != '')<button class="w-20 mr-1 action-loader text-success">{{ $message }}</button>@endif


                    <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-20">Update</button>
                </div>
                <!-- END: Slide Over Footer -->

            </form>
        </div>
    </div>
</div>
<!-- END: Edit Fee -->