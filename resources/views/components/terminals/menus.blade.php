<div id="menu-list" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="my-form" :action="action">

                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto slide-over-title">Services</h2>
                </div>
                <!-- END: Slide Over Header -->

                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    @csrf
                    <div class="alert alert-primary-soft flex items-center mb-2" role="alert">
                        Terminal ID -
                        <span class="italic font-medium" x-text="terminal.tid"></span>; Serial No -
                        <span class="italic font-medium" x-text="terminal.serial"></span>.
                    </div>

                    @can('edit terminals')
                        <x-note message="After adding or deleting menus from this terminal, ensure to save it before exiting." />
                    @endcan

                    <ul class="mt-5">
                        <template x-for="(service, index) in current_menus" :key="service.id">
                            <div class="bg-white border border-secondary border-1 shadow-sm rounded w-3/4 my-3 mr-5 p-1">
                                <input type="hidden" name="menus[]" :value="service.id">
                                <div class="flex items-center justify-between">
                                    <div x-text="service.menu_name" class="px-2"></div>
                                    @can('edit terminals')
                                        <button type="button" @click="deleteMenu(index)"
                                                class="text-danger border-0 rounded-full cursor-pointer px-2 py-2 hover:bg-danger/10 transition-colors duration-200"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4 block mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </template>
                    </ul>

                    @can('edit terminals')
                        <h5 class="font-medium mb-2 mt-5">- Add Menu to Terminal by selecting from below</h5>

                        <select class="form-select w-3/4" name="" x-model="new_menu" id="" @change="addNewMenu">
                            <option value=""></option>
                            {{--                        Get the difference between the default menus and the current terminal menus to see which can still be added. --}}
                            <template x-for="(service, index) in others" :key="service.id">
                                <option :value="index" x-text="service.menu_name"></option>
                            </template>
                        </select>

                        <div class="mt-20"></div>
                    @endcan

                </div>
                <!-- END: Slide Over Body -->
                @can('edit terminals')
                    <!-- BEGIN: Slide Over Footer -->
                    <div class="modal-footer w-full flex justify-end gap-4 absolute bottom-0">
                        <button type="reset" data-tw-dismiss="modal" class="btn btn-outline-secondary px-5 w-fit">Cancel</button>
                        <button type="submit" class="btn btn-primary px-5 w-fit">Save</button>
                    </div>
                    <!-- END: Slide Over Footer -->
                @endcan
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('service_menus', () => ({
                current_menus: [],
                terminal: {},
                action: null,

                new_menu: {},
                others: [],

                initializeModal(menus, action, terminal) {
                    this.current_menus = menus;
                    this.terminal = terminal;
                    this.action = action;

                    this.setAvailableMenus();
                },

                setAvailableMenus() {
                    let default_menus = @js(app('menus'));

                    this.others = default_menus.filter(
                        menu1 => !this.current_menus.some(menu2 => menu1.id === menu2.id),
                    );
                },

                addNewMenu() {
                    this.current_menus.push(this.others[this.new_menu])
                    this.others.splice(this.new_menu, 1)
                },

                deleteMenu(index) {
                    this.others.push(this.current_menus[index])
                    this.current_menus.splice(index, 1)
                },
            }))
        })
    </script>
@endpush
