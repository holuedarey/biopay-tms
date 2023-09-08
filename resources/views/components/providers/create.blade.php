<div id="create-provider" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{--            <form method="post" action="">--}}
            <form method="post" class="my-form" action="{{ route('providers.store') }}">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Add new provider
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    @csrf
                    <div class="mt-6">
                        <label for="name" class="form-label w-fit">Provider Name</label>
                        <div class="w-full">
                            <input id="name" type="text" class="form-control" placeholder="Enter the provider name"
                                   name="name" required
                            >
                            <x-input-error input-name="name" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <label for="description" class="form-label w-fit">Service Description</label>
                        <div class="w-full">
                            <select data-placeholder="Select your favorite actors" name="services[]" class="tom-select w-full" multiple required>
                                <option value="" disabled selected></option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error input-name="services" />
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
