@props(['user'])

<div class="report-box">
    <div class="intro-y box p-5">
        <div class="flex flex-col md:flex-row -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <form action="{{ route('users.update', $user) }}" method="post" class="avatar-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                        <x-user-avatar :user="$user" class="rounded-full" />
                        <label for="avatar" class="absolute cursor-pointer mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2">
                            <i class="w-4 h-4 text-white" data-lucide="camera"></i>
                            <input type="file" name="avatar" class="hidden" id="avatar" onchange="this.closest('form').submit()">
                        </label>
                    </div>
                </form>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 mb-2 sm:whitespace-normal font-medium sm:text-lg">{{ $user->name }}</div>
                    <div class="flex flex-col gap-3">
                        <livewire:user-status-badge :user="$user"/>
                        <a class="flex gap-2 text-xs hover:text-info transition duration-300" href="#"
                           data-tw-toggle="modal" data-tw-target="#edit-profile"
                        >
                            <i data-lucide="edit" class="text-info w-4 h-4"></i>
                            Edit Profile
                        </a>
                        @if($allow = $user->is(Auth::user()))
                            <a class="flex gap-2 text-xs hover:text-pending transition duration-300" href="#"
                               data-tw-toggle="modal" data-tw-target="#change-password"
                            >
                                <i data-lucide="unlock" class="text-pending w-4 h-4"></i>
                                Change Password
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <i data-lucide="mail" class="w-4 h-4 mr-2 text-red-600"></i>
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        <i data-lucide="smartphone" class="w-4 h-4 mr-2 text-blue-600"></i>
                        <a href="tel:{{  $user->phone }}">{{ $user->phone }}</a>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-cyan-600"></i>
                        {{ "$user->address, $user->state." }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('modals')
    <x-users.edit-profile :$user />
    @if($allow)
        <x-users.change-password />
    @endif
@endpush
