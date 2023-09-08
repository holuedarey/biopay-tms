<div id="edit-processor" class="modal modal-slide-over" tabindex="-1" aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            {{--            <form method="post" action="">--}}
            <form method="post" class="my-form" :action="action">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Update Processor
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="device" class="form-label sm:w-24">Name</label>
                        <div class="w-full">
                            <input id="name" type="text" class="form-control" placeholder="Enter the processor name" name="name"
                                   x-model="processor.name"
                            >
                            <x-input-error input-name="name" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="host" class="form-label sm:w-24">Host</label>
                        <div class="w-full">
                            <input id="processor_id" type="text" class="form-control" placeholder="Enter processor host" name="host"
                                   x-model="processor.host"
                            >
                            <x-input-error input-name="host" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="port" class="form-label sm:w-24">Port </label>
                        <div class="w-full">
                            <input id="port" type="text" class="form-control" placeholder="Enter Port" name="port"
                                   x-model="processor.port"
                            >
                            <x-input-error input-name="port" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="comp1" class="form-label">Component Key 1</label>
                        <div class="w-full">
                            <input id="comp1" type="text" class="form-control" placeholder="Enter the component key 1" name="comp1"
                                   x-model="processor.comp1"
                            >
                            <x-input-error input-name="comp1" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="comp2" class="form-label">Component Key 2</label>
                        <div class="w-full">
                            <input id="comp2" type="text" class="form-control" placeholder="Enter the component key 1" name="comp2"
                                   x-model="processor.comp2"
                            >
                            <x-input-error input-name="comp2" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="zpk" class="form-label sm:w-24">Zone Pin Key</label>
                        <div class="w-full">
                            <input id="zpk" type="text" class="form-control" placeholder="Enter the zone pin key" name="zpk"
                                   x-model="processor.zpk"
                            >
                            <x-input-error input-name="zpk" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-6">
                        <div class="form-check form-switch">
                            <input type="hidden" name="ssl" :value="processor.ssl ? 1 : 0">
                            <label for="">
                                <input class="form-check-input" type="checkbox"
                                       @change="processor.ssl = !processor.ssl" :checked="processor.ssl"
                                >
                                &nbsp;&nbsp;SSL
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <input type="hidden"  name="requiresKey" :value="processor.requiresKey ? 1 : 0">
                            <label for="">
                                <input class="form-check-input" type="checkbox"
                                       @change="processor.requiresKey = !processor.requiresKey" :checked="processor.requiresKey"
                                >
                                &nbsp;&nbsp;Requires key
                            </label>
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
