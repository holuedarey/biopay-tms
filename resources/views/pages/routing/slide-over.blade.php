<!-- BEGIN: Add -->
<div id="add-routing-setting" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" wire:submit.prevent="save">

                <input type="hidden" name="type" value="{{ $type }}">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Add {{ $type }} setting
                    </h2>
                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">

                    <h3 id="validation-error" class="mt-2 mb-2 text-danger"></h3>

                    <div class="mt-6">
                        <label for="min_amount" class="form-label w-fit">Min Amount</label>
                        <div class="w-full">
                            <input id="min_amount" type="number" min="0" max="2000000" class="form-control" value="0.00" wire:model="item.min_amount">
                            <x-input-error input-name="min_amount" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="max_amount" class="form-label w-fit">Max Amount</label>
                        <div class="w-full">
                            <input id="max_amount" type="number" min="0" max="2000000" class="form-control" value="0.00" wire:model="item.max_amount">
                            <x-input-error input-name="max_amount" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="primary_id" class="form-label w-fit">Primary Processor</label>
                        <div class="w-full">
                            <select id="primary_id" data-placeholder="Select Processor" wire:model="item.primary_id" class="w-full" required>
                                @foreach($processors as $processor)
                                    <option value="{{ $processor->id }}">{{ $processor->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error input-name="primary_id" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="secondary_id" class="form-label w-fit">Secondary Processor</label>
                        <div class="w-full">
                            <select id="secondary_id" data-placeholder="Select Processor" wire:model="item.secondary_id" class="w-full" required>
                                @foreach($processors as $processor)
                                    <option value="{{ $processor->id }}">{{ $processor->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error input-name="secondary_id" />
                        </div>
                    </div>

                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div class="modal-footer w-full flex justify-end gap-4 absolute bottom-0">
                    <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary px-5 w-fit">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 w-fit">Submit</button>
                </div>
                <!-- END: Slide Over Footer -->

            </form>
        </div>
    </div>
</div>
<!-- END: Add -->



<!-- BEGIN: Edit Groups -->
<div id="edit-routing-setting" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" wire:submit.prevent="update">

                <input type="hidden" name="type" value="{{ $type }}">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Edit {{ $type }} setting
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    <div class="mt-6">
                        <label for="min_amount" class="form-label w-fit">Min Amount</label>
                        <div class="w-full">
                            <input id="min_amount" type="number" min="0" max="2000000" class="form-control" value="0.00" wire:model="item.min_amount" required
                            >
                            <x-input-error input-name="min_amount" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="max_amount" class="form-label w-fit">Max Amount</label>
                        <div class="w-full">
                            <input id="max_amount" type="number" min="0" max="2000000" class="form-control" value="0.00" wire:model="item.max_amount" required
                            >
                            <x-input-error input-name="max_amount" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="primary_id" class="form-label w-fit">Primary Processor</label>
                        <div class="w-full">
                            <select id="primary_id" data-placeholder="Select Processor" wire:model="item.primary_id" class="tom-select w-full" required>
                                @foreach($processors as $processor)
                                    <option value="{{ $processor->id }}">{{ $processor->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error input-name="primary_id" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="secondary_id" class="form-label w-fit">Secondary Processor</label>
                        <div class="w-full">
                            <select id="secondary_id" data-placeholder="Select Processor" wire:model="item.secondary_id" class="tom-select w-full" required>
                                @foreach($processors as $processor)
                                    <option value="{{ $processor->id }}">{{ $processor->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error input-name="secondary_id" />
                        </div>
                    </div>


                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div class="modal-footer w-full flex justify-end gap-4 absolute bottom-0">

                    @if($msg != '')<button class="w-20 mr-1 action-loader text-success">{{ $msg }}</button>@endif

                    <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary px-5 w-fit">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 w-fit">Update</button>
                </div>
                <!-- END: Slide Over Footer -->

            </form>
        </div>
    </div>
</div>
<!-- END: Edit Groups -->
