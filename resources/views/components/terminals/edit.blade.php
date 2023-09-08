<div id="edit-terminal" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{--            <form method="post" action="">--}}
            <form method="post" class="my-form" :action="action">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Update Terminal
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="mt-4">
                        <label for="group" class="form-label sm:w-24">Group</label>
                        <div class="w-full">
                            <select name="group_id" id="group" class="form-select" x-model="terminal.group_id">
                                @foreach(app('terminal_groups') as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error input-name="group_id" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="device" class="form-label sm:w-24">Device</label>
                        <div class="w-full">
                            <input id="device" type="text" class="form-control" placeholder="Enter the device name" name="device"
                                   x-model="terminal.device"
                            >
                            <x-input-error input-name="device" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="terminal_id" class="form-label sm:w-24">Terminal ID</label>
                        <div class="w-full">
                            <input id="terminal_id" type="text" class="form-control" placeholder="Enter Terminal ID" name="tid"
                                   x-model="terminal.tid"
                            >
                            <x-input-error input-name="tid" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="merchant_id" class="form-label sm:w-24">Merchant ID </label>
                        <div class="w-full">
                            <input id="merchant_id" type="text" class="form-control" placeholder="Enter Merchant ID" name="mid"
                                   x-model="terminal.mid"
                            >
                            <x-input-error input-name="mid" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="serial_no" class="form-label sm:w-24">Serial</label>
                        <div class="w-full">
                            <input id="serial_no" type="text" class="form-control" placeholder="Enter the device serial number" name="serial"
                                   x-model="terminal.serial"
                            >
                            <x-input-error input-name="serial" />
                        </div>
                    </div>

                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div class="modal-footer w-full flex justify-end gap-4 absolute bottom-0">
                    <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary px-5 w-fit">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 w-fit">Save</button>
                </div>
                <!-- END: Slide Over Footer -->

            </form>
        </div>
    </div>
</div>
