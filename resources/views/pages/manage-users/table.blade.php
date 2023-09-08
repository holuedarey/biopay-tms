<div class="col-span-12 mt-6 bg-white px-5 py-3">
    <div class="w-full flex sm:flex-row flex-col gap-2 justify-between items-center sm:w-auto mt-3 mb-1 sm:mt-0 lg:ml-auto md:ml-0">
        <p class="font-medium py-2">Showing List of {{ ucwords($name) }}</p>

        <div class="md:w-72 sm:w-64 w-full relative text-slate-500">
            <input type="text" class="form-control w-full pr-10" wire:model.debounce.500ms="search"
                   placeholder="Search name, email account number..." aria-describedby="Search" aria-label="Search"
            >
            <span wire:ignore>
            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
        </span>
        </div>
    </div>

    <div class="intro-y overflow-auto sm:mt-0">
        <table class="table table-report table-auto table-hover">
            <thead>
            <tr class="bg-gray-200">
                <th></th>
                <th class="whitespace-nowrap">NAME</th>
                <th class="whitespace-nowrap">EMAIL</th>
                <th class="whitespace-nowrap">PHONE</th>
                @if($showLevel)
                    <th class="whitespace-nowrap">LEVEL</th>
                @endif
                @if($showRole)
                    <th class="whitespace-nowrap">ROLE</th>
                @endif
                <th class="whitespace-nowrap">STATUS</th>
                <th class="whitespace-nowrap">DATE REGISTERED</th>

                @if($roleAction)
                    <th class="text-center whitespace-nowrap">
                    <span class="flex justify-center">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                    </span>
                    </th>
                @endif
            </tr>
            </thead>
            <tbody>
            @if($users->count() > 0)
                @foreach ($users as $user)
                    <tr class="intro-x">
                        <td class="w-20">
                            <div class="flex">
                                <div class="w-10 h-10 image-fit zoom-in">
                                    <x-user-avatar :user="$user" class="rounded-full" />
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap font-medium">
                            <a href="{{ route('users.show', $user->id) }}"
                               class="hover:opacity-70"
                            >
                                {{ $user->name }}
                            </a>
                        </td>

                        <td class=""><a href="mailto:{{$user->email}}">{{ $user->email }}</a></td>

                        <td class="">{{ $user->phone }}</td>

                        @if($showLevel)
                            <td><x-badge>{{ $user->kycLevel->name }}</x-badge></td>
                        @endif

                        @if($showRole)
                            <td class=""><x-badge class="bg-primary">@nbsp($user->roleName)</x-badge></td>
                        @endif

                        <td class="">
                            <livewire:user-status-badge :user="$user" wire:key="status-badge-{{ $user->id }}"/>
                        </td>

                        <td class="">{{ $user->created_at->toDayDateTimeString() }}</td>

                        @if(!is_null($roleAction))
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <form method="POST" action="{{ route('roles.users.destroy', [$roleAction, $user]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#"
                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                           class="flex items-center text-orange-600"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Remove
                                        </a>
                                    </form>
                                </div>
                            </td>
                        @endif

                    </tr>
                @endforeach
            @else
                <tr><td colspan="9" class="text-center">No users available.</td></tr>
            @endif
            </tbody>
        </table>
        <div>
            {{ $users->links()}}
        </div>
    </div>
</div>
