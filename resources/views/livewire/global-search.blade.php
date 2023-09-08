<div class="intro-x relative mr-3 sm:mr-6">
    <div class="search hidden sm:block">
        <input type="text" class="search__input form-control border-transparent" placeholder="Search user's name, email, phone..."
               wire:model.debounce.500ms="search"
        >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="search" data-lucide="search" class="lucide lucide-search search__icon dark:text-slate-500"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
    </div>
    <a class="notification notification--light sm:hidden" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="search" data-lucide="search" class="lucide lucide-search notification__icon dark:text-slate-500"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
    </a>
    <div class="search-result" wire:ignore.self>
        <div class="search-result__content">
            <div class="search-result__content__title">Search results</div>
            <div class="mb-5">
                @foreach($users as $user)
                    <a href="{{ route('users.show', $user) }}" class="flex cursor-pointer items-center rounded px-2 py-1 hover:bg-gray-100 mt-2" wire:key="{{ $user->id }}">
                        <div class="w-8 h-8 image-fit">
                            <img alt="User Avatar" class="rounded-full" src="{{ $user->avatar }}">
                        </div>
                        <div class="ml-3 truncate">{{ $user->name }}</div>
                        <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">{{ $user->email }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
