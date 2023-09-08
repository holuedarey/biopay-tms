<div id="edit-service" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{--            <form method="post" action="">--}}
            <form method="post" class="my-form" :action="action">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Update Service Info
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="mt-6">
                        <label for="name" class="form-label w-fit">Service Name</label>
                        <div class="w-full">
                            <input id="name" type="text" class="form-control" placeholder="Enter the device name"
                                   name="name" x-model="service.name"
                            >
                            <x-input-error input-name="name" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="description" class="form-label w-fit">Service Description</label>
                        <div class="w-full">
                            <textarea id="description" class="form-control" placeholder="Enter service description"
                                   name="description" x-model="service.description" rows="5"
                            ></textarea>
                            <x-input-error input-name="description" />
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
