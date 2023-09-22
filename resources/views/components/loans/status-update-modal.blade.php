<!-- BEGIN: Modal Content -->
<div id="status-update-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form :action="action" method="post" class="my-form">
                <div class="modal-body p-0">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" x-model="loanStatus" />

                    <div class="p-5 text-center">
                        <i data-lucide="help-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">
                            Do you want to mark this loan request as
                            <span class="font-medium uppercase" x-text="loanStatus"></span>?
                        </div>
                    </div>

                    <template x-if="loanStatus === '{{ \App\Enums\Status::APPROVED->value }}'">
                        <div class="px-5 mb-3">
                            <label for="amount" class="form-label">Change the loan amount</label>
                            <input type="number" name="amount" id="amount" min="500" class="form-control form-input">
                        </div>
                    </template>

                    <template x-if="loanStatus === '{{ \App\Enums\Status::DECLINED->value }}'">
                        <div class="px-5 mb-3">
                            <label for="reason" class="form-label">Reason for decline</label>
                            <textarea name="decline_reason" id="reason" class="form-control form-textarea" rows="4"></textarea>
                        </div>
                    </template>
                </div>

                <div class="modal-footer flex justify-end gap-3">
                    <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-outline-danger">No</button>
                    <button type="submit" class="btn w-24 btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: Modal Content -->
