@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('../layout/components/mobile-menu')
    @include('../layout/components/top-bar')
    <div class="flex overflow-hidden">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <ul>
                @foreach ($side_menu as $menuKey => $menu)
                    @if ($menu == 'devider')
                        <li class="side-nav__devider my-6"></li>
                    @else
                        @if(!isset($menu['permission']) || Auth::user()->canAny($menu['permission']))
                            <li>
                                <a href="{{ isset($menu['route_name']) ? route($menu['route_name']) : 'javascript:;' }}" class="{{ $first_level_active_index == $menuKey || request()->segment(1) == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                    <div class="side-menu__icon">
                                        <i data-lucide="{{ $menu['icon'] }}"></i>
                                    </div>
                                    <div class="side-menu__title">
                                        {{ $menu['title'] }}
                                        @if (isset($menu['sub_menu']))
                                            <div class="side-menu__sub-icon {{ $first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}">
                                                <i data-lucide="chevron-down"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                @if (isset($menu['sub_menu']))
                                    <ul class="{{ $first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
                                        @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                            @if(!isset($subMenu['permission']) || Auth::user()->canAny($subMenu['permission']))
                                                <li>
                                                    <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name']) : 'javascript:;' }}"
                                                       class="{{ $second_level_active_index == $subMenuKey ? 'side-menu side-menu--active bg-white/50 mx-1.5' : 'side-menu' }}">
                                                        <div class="side-menu__icon">
                                                            <i data-lucide="{{$subMenu['icon'] ?? 'disc'}}" style="width: 14px;"></i>
                                                        </div>
                                                        <div class="side-menu__title">
                                                            {{ $subMenu['title'] }}
                                                            @if (isset($subMenu['sub_menu']))
                                                                <div class="side-menu__sub-icon {{ $second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}">
                                                                    <i data-lucide="chevron-down"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                    @if (isset($subMenu['sub_menu']))
                                                        <ul class="{{ $second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                                                            @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                                <li>
                                                                    <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name']) : 'javascript:;' }}" class="{{ $third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                                        <div class="side-menu__icon">
                                                                            <i data-lucide="zap"></i>
                                                                        </div>
                                                                        <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endif
                @endforeach

                @if(Auth::user()->hasRole(\App\Models\Role::APPROVER))
                    <li>
                        <a href="{{ route('approvals.index') }}" @class(['side-menu', 'side-menu--active' => request()->routeIs('approvals.index')])>
                            <div class="side-menu__icon">
                                <i data-lucide="user-check"></i>
                            </div>
                            <div class="side-menu__title">Approvals</div>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">

            <!-- BEGIN: Session Msg -->
            <div class="my-5">
                <x-session-msg />
                <x-validation-errors />
            </div>

            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
@endsection
