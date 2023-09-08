<div id="view-approval" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
            <template x-if="Object.keys(approval).length !== 0">
                <div>
                    <!-- BEGIN: Slide Over Header -->
                    <div class="modal-header">
                        <h2 class="text-lg font-medium"
                            x-text="`${approval.resource} was ${approval.action?.toUpperCase()} by ${approval.author.name}`">
                        </h2>

                    </div>
                    <!-- END: Slide Over Header -->
                    <div class="modal-body">
                        <p class="mb-1">
                            <span class="font-medium" x-text="`Date ${approval.action}:`"></span>
                            <span x-text="(new Date(approval.created_at)).toLocaleString()"></span>
                        </p>
                        <p x-text="`The details of the ${approval.action} attributes are shown below:`"></p>
                        <div class="grid grid-cols-3 mt-2 font-medium text-slate-500">
                            <div class="col-span-1">Attribute</div>
                            <div class="col-span-1">New value</div>
                            <template x-if="approval.action === 'updated'">
                                <div class="col-span-1">Old value</div>
                            </template>
                        </div>

                        <hr>

                        <template x-for="key in Object.keys(approval.new_data)" :key="key">
                            <div class="grid grid-cols-3 py-1.5">
                                <div class="col-span-1 font-medium" x-text="key.replace('_', ' ')"></div>
                                <div class="col-span-1" x-text="approval.new_data[key]"></div>
                                <template x-if="approval.action === 'updated'">
                                    <div class="col-span-1 text-slate-500" x-text="approval.original_data[key]"></div>
                                </template>
                            </div>
                        </template>
                    </div>
                    <!-- END: Slide Over Body -->
                    <!-- BEGIN: Slide Over Footer -->
                    <div class="modal-footer w-full flex justify-end gap-4 my-3">
                        <form :action="approvalRoute" method="post" class="my-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-5 w-fit spinner-dark">
                                <div class="flex gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="thumbs-down" data-lucide="thumbs-down" class="lucide lucide-thumbs-down w-4 h-4 mr-1">
                                        <path d="M10 15v4a3 3 0 003 3l4-9V2H5.72a2 2 0 00-2 1.7l-1.38 9a2 2 0 002 2.3zm7-13h2.67A2.31 2.31 0 0122 4v7a2.31 2.31 0 01-2.33 2H17"></path>
                                    </svg>
                                    Decline
                                </div>
                            </button>
                        </form>

                        <form :action="approvalRoute" method="post" class="my-form">
                            @csrf
                            @method('PUT')

                            <button type="submit" class="btn btn-success text-white px-5 w-fit">
                                <div class="flex gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="thumbs-up" data-lucide="thumbs-up" class="lucide lucide-thumbs-up w-4 h-4 mr-1">
                                        <path d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"></path>
                                    </svg>
                                    Approve
                                </div>
                            </button>
                        </form>
                    </div>
                    <!-- END: Slide Over Footer -->
                </div>
            </template>
        </div>
    </div>
</div>
