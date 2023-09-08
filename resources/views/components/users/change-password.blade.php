<div id="change-password" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{--            <form method="post" action="">--}}
            <form method="post" class="my-form" action="{{ route('users.update', Auth::user()) }}">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">
                        Change Your Password
                    </h2>

                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="current" class="form-label">Current Password</label>
                        <div class="w-full">
                            <input id="current" type="password" class="form-control" name="current">
                            <x-input-error input-name="current" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="password" class="form-label">New Password</label>
                        <div class="w-full">
                            <input id="password" type="password" class="form-control" name="password">
                            <x-input-error input-name="password" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="w-full">
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                            <x-input-error input-name="password_confirmation" />
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
