<div class="offcanvas offcanvas-end" style="width: 60%" tabindex="-1" id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-primary">
        <h5 class="offcanvas-title text-light" id="offcanvasRightLabel">Menus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body off-sidebar">
        <aside class="sidebarcontent w-100 position-relative overflow-auto" id="asideforscroll">
            <ul class="navbar-nav position-absolute mt-3">
                @php
                    $menus = sidemenu();
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
                    <li class="nav-item flex-column {{ $isActive ? 'active' : '' }}">
                        <div class="d-flex w-100 align-items-center">
                            <div class="icon-width">
                                <i class="{{ $menu->icon }}"></i>
                            </div>
                            <a class="nav-link fs-14 {{ $menu->collapse == true ? 'dropdown-toggle d-flex align-items-center justify-content-between pe-2' : '' }}"
                                {{ $menu->collapse == true ? 'data-bs-toggle=collapse aria-expanded=false' : '' }}
                                href="{{ $menu->route == '' ? '#' . $menu->id : route($menu->route) }}">{{ $menu->name }}</a>
                        </div>
                    </li>
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
                    @if ($filteredMenus->isNotEmpty())
                        <div class="collapse w-100" id="{{ $menu->id }}">
                            <ul class="list-none m-auto submenu-collpase p-0 d-flex flex-column">
                                @foreach ($filteredMenus->sortBy('order') as $submenu)
                                    <li class="auth-submenu {{ request()->routeIs($submenu->route) ? 'active' : '' }}">
                                        <a href="{{ route($submenu->route) }}"
                                            class="dropdown-item word-wrap bg-transparent p-2 fs-14">{{ $submenu->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </ul>
        </aside>
    </div>
</div>