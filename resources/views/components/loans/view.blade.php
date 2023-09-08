<div id="view-modal" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Slide Over Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto slide-over-title">
                    Loan Details
                </h2>

            </div>
            <!-- END: Slide Over Header -->
            <!-- BEGIN: Slide Over Body -->
            <div class="modal-body">
                <div class="my-5">
                    <p class="font-medium text-xs py">Request Amount</p>
                    <p class="text-base text-slate-600" x-text="`${loan?.user?.name} - ${loan?.user?.email}`"></p>
                </div>
                <div class="my-5">
                    <p class="font-medium text-xs py">Request Amount</p>
                    <p class="text-base text-slate-600" x-text="`₦${loan?.amount}`"></p>
                </div>
                <div class="my-5">
                    <p class="font-medium text-xs">Approved Amount</p>
                    <p class="text-base text-slate-600" x-text="`₦${loan?.transaction?.amount}`"></p>
                </div>
                <div class="my-5">
                    <p class="font-medium text-xs">Status</p>
                    <p class="text-base text-slate-600" x-text="loan?.status"></p>
                </div>
                <div class="my-5">
                    <p class="font-medium text-xs">Items</p>
                    <ul class="list-disc">
                        <template x-for="item in loan?.items">
                            <li class="text-base text-slate-600" x-text="item"></li>
                        </template>
                    </ul>
                </div>
                <div class="my-5">
                    <p class="font-medium text-xs">Info</p>
                    <p class="text-sm text-slate-600" x-text="loan?.info ?? '...'"></p>
                </div>
                @if(auth()->user()->isAdmin())
                    <div class="my-5">
                        <p class="font-medium text-xs">Confirmed By</p>
                        <p class="text-base text-slate-600" x-text="loan?.confirmed_by ?? '...'"></p>
                    </div>
                    <div class="my-5">
                        <p class="font-medium text-xs">Declined by</p>
                        <p class="text-base text-slate-600" x-text="loan?.declined_by ?? '...'"></p>
                    </div>
                @endif
                <div class="my-5">
                    <p class="font-medium text-xs">Declined reason</p>
                    <p class="text-sm text-slate-600" x-text="loan?.declined_reason ?? '...'"></p>
                </div>
            </div>
            <!-- END: Slide Over Body -->
            <!-- BEGIN: Slide Over Footer -->
            <div class="modal-footer w-full flex justify-end gap-4 absolute bottom-0">
                <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary px-5 w-fit">Close</button>
{{--                <button type="submit" class="btn btn-primary px-5 w-fit">Save</button>--}}
            </div>
            <!-- END: Slide Over Footer -->
        </div>
    </div>
</div>
