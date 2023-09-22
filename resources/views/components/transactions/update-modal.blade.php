<div>
    <!-- BEGIN: Modal Content -->
    <div id="fail-transaction-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to mark this transaction as <span class="text-danger font-medium">FAILED</span>? <br>This process cannot be undone.</div>
                    </div>
                    <form :action="route" method="post" class="px-5 pb-8 flex justify-center my-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ \App\Enums\Status::FAILED->value }}">

                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">No</button>
                        <button type="submit" class="btn btn-danger w-24">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="success-transaction-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you Sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to mark this transaction as <span class="text-success font-medium">SUCCESSFUL</span>? <br>This process cannot be undone.</div>
                    </div>
                    <form :action="route" method="post" class="px-5 pb-8 flex justify-center my-form">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="status" value="{{ \App\Enums\Status::SUCCESSFUL->value }}">

                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">No</button>
                        <button type="submit" class="btn btn-success w-24">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Modal Content -->
</div>
