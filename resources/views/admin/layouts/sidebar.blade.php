<div class="sidebar-container p-2 position-relative d-flex flex-wrap justify-content-center align-items-center">
    <div class="text-center">
        <a class="navbar-brand navbar-logo" href="#">
            <img src="{{ webData()->logo->external_link ?? '' }}" alt="Logo">
        </a>
        <div class="text-center">
            <span class="text-uppercase fs-14">
                {{ setting('site_short_name') }}
            </span>
        </div>
    </div>
    <div class="position-absolute end-0 d-block d-lg-none  me-2">
        <i class="fas fa-arrow-left text-light fa-2x  pointer" data-menu-close></i>
    </div>
</div>
{{-- <div class="position-absolute w-100 px-3 bottom-info-container">
     <div class="bg-sub p-3 card-rounded w-100 d-flex flex-wrap align-items-center justify-content-between">
        <div class="profile-img-nav d-flex align-items-center me-2" type="button" id="profileuserauth"
            data-bs-toggle="dropdown" data-bs-target="profiledropdown" aria-expanded="false">
            <img src="{{ asset(str_replace('storage', 'public', user()->image ?? user()->img)) }}"
                onerror="this.src='{{ asset('storage/icons/user.png') }}'" class="img-fluid" alt="userimage">
        </div>
        <div class="d-flex text-dark">
            <span>{{ user()->name ?? (user()->first_name ?? '') }}</span>
        </div>
        <div class="">
            <a href="{{ route('logout') }}"><i class="fas fa-power-off text-dark pointer font-1"></i></a>
        </div>
    </div>
</div>
 --}}
<aside class="sidebarcontent w-100 position-relative overflow-auto" id="asideforscroll">
    <ul class="navbar-nav position-absolute mt-3">
        @php
            $menus = menu();
        @endphp
        @foreach ($menus->sortBy('order') as $menu)
            @php
                $isActive = request()->routeIs($menu->route);
                foreach ($menu->submenu as $submenu) {
                    if (request()->routeIs($submenu->route)) {
                        $isActive = true;
                        break;
                    }
                }
            @endphp
            @php
                $submenu = $menu->submenu->whereNotNull('route');
                if (user()->dflt == true && user()->instance() == 'admin') {
                    $filteredMenus = $submenu;
                } else {
                    $filteredMenus = $submenu->filter(function ($submenu) {
                        return $submenu
                            ->permissions()
                            ->where('uid', user()->id)
                            ->where('read', true)
                            ->where('user_type', user()->instance())
                            ->exists();
                    });
                }
            @endphp
            <li class="nav-item flex-column {{ $isActive ? 'active' : '' }}">
                <div class="d-flex w-100 align-items-center">
                    <div class="icon-width">
                        <i class="{{ $menu->icon }}"></i>
                    </div>
                    <a class="nav-link fs-14  {{ $menu->collapse == true ? 'dropdown-toggle d-flex align-items-center justify-content-between pe-2' : '' }}"
                        {{ $menu->collapse == true ? 'data-bs-toggle=collapse aria-expanded=' . ($isActive ? 'true' : 'false') : '' }}
                        href="{{ $menu->route == '' ? '#' . $menu->id : route($menu->route) }}">{{ $menu->name }}</a>
                </div>
                @if ($filteredMenus->isNotEmpty())
                    <div class="collapse w-100 {{ $isActive ? 'show' : '' }}" id="{{ $menu->id }}">
                        <ul class="list-none m-auto submenu-collpase p-0 d-flex flex-column">
                            @foreach ($filteredMenus->sortBy('order') as $submenu)
                                <li class="auth-submenu list-style {{ request()->routeIs($submenu->route) ? 'active' : '' }}">
                                    <a href="{{ route($submenu->route) }}"
                                        class="dropdown-item word-wrap bg-transparent p-2 fs-14">{{ $submenu->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</aside>
