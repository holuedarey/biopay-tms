<!-- BEGIN: Create Groups -->
    <div id="create-groups" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('terminal-groups.store') }}">
                    <!-- BEGIN: Slide Over Header -->
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto">
                            Add New Terminal Group
                        </h2>

                    </div>
                    <!-- END: Slide Over Header -->
                    <!-- BEGIN: Slide Over Body -->
                    <div class="modal-body">
                        <div class="mb-5">
                            <label for="name" class="form-label">Name</label>
                            <div class="w-full">
                                <input id="name" type="text" class="form-control" placeholder="Enter group name" name="name" value="{{ old('name') }}">
                                <x-input-error input-name="name" />
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
