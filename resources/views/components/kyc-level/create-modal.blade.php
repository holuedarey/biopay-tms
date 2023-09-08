<div id="create-kyc-level" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">Add New KYC Level</h2>
            </div>
            <form method="post" action="{{ route('kyc-levels.store') }}">
                <div class="modal-body">
                    @csrf

                    <x-note message="The daily limit must be less than the maximum balance and the single transaction limit must be less than the daily limit"/>

                    <div class="mt-3">
                        <label for="name" class="form-label sm:w-56">Level Name</label>
                        <div class="w-full">
                            <input id="name" type="text" class="form-control" placeholder="Enter the name of the level" name="name" value="{{ old('name') }}">
                            <x-input-error input-name="name" />
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="max_balance" class="form-label sm:w-56">Maximum Balance</label>
                        <div class="w-full">
                            <input id="max_balance" type="text" class="form-control" placeholder="0.00" name="max_balance" value="{{ old('max_balance') }}">
                            <x-input-error input-name="max_balance" />
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="daily_limit" class="form-label sm:w-56">Daily Limit</label>
                        <div class="w-full">
                            <input id="daily_limit" type="text" class="form-control" placeholder="0.00" name="daily_limit" value="{{ old('daily_limit') }}">
                            <x-input-error input-name="daily_limit" />
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="single_trans_max" class="form-label sm:w-56">Single Transaction Maximum</label>
                        <div class="w-full">
                            <input id="single_trans_max" type="text" class="form-control" placeholder="0.00" name="single_trans_max" value="{{ old('single_trans_max') }}">
                            <x-input-error input-name="single_trans_max" />
                        </div>
                    </div>
                </div>
                <!-- BEGIN: Slide Over Footer -->
                <div class="modal-footer w-full absolute bottom-0">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button class="btn btn-primary w-20">Submit</button>
                </div>
                <!-- END: Slide Over Footer -->
            </form>
        </div>
    </div>
</div> <!-- END: Slide Over Content -->
