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
                        <label for="device" class="form-label sm:w-24">Serial</label>
                        <div class="w-full">
                            <input id="serial" type="text" class="form-control" name="serial"
                                   x-model="processor.serial"
                            >
                            <x-input-error input-name="serial" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="tid" class="form-label sm:w-24">Teminal ID</label>
                        <div class="w-full">
                            <input id="tid" type="text" class="form-control" name="tid"
                                   x-model="processor.tid"
                            >
                            <x-input-error input-name="tid" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="mid" class="form-label sm:w-24">Merchant ID </label>
                        <div class="w-full">
                            <input id="mid" type="text" class="form-control" name="mid"
                                   x-model="processor.mid"
                            >
                            <x-input-error input-name="mid" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="category_code" class="form-label">Category code</label>
                        <div class="w-full">
                            <input id="category_code" type="text" class="form-control" placeholder="Enter the category code" name="category_code"
                                   x-model="processor.category_code"
                            >
                            <x-input-error input-name="category_code" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="nl" class="form-label">Name Location</label>
                        <div class="w-full">
                            <input id="nl" type="text" class="form-control" placeholder="Enter the name location" name="nl"
                                   x-model="processor.nl"
                            >
                            <x-input-error input-name="nl" />
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
