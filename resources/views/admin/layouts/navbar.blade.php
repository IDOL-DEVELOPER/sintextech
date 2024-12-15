<div class="m-auto rounded-5 py-3 {{ setting('header-sticky') == true ? 'position-sticky' : '' }} navbar-main navbar navbar-expand-md"
    id="navbarmainfor">
    <div class="w-100 d-md-flex justify-content-between px-3 align-items-center main-navbar">
        <div class="d-flex justify-content-between align-items-center dms-nav-collpase">
            <div class="me-4">
                <input type="checkbox" hidden id="menushow">
                <label for="menushow" class="menushow h-100 d-flex align-items-center flex-column pointer custom-tooltip">
                    <div class="bg-primary menu-bar mb-1"></div>
                    <div class="bg-primary menu-bar mb-1"></div>
                    <div class="bg-primary menu-bar"></div>
                </label>
            </div>
            <div class="d-none d-md-flex">
                @php
                    $menus = navmenu();
                @endphp
                @foreach ($menus as $menu)
                    <li class="nav-item dropdown list-none me-2">
                        <a class="nav-link {{ $menu->collapse == true ? 'dropdown-toggle' : '' }}"
                            href="{{ $menu->route == '' ? '#' . $menu->id : route($menu->route) }}" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $menu->name }}
                        </a>
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
                            <ul class="dropdown-menu list-none" id="{{ $menu->id }}">
                                @foreach ($filteredMenus->sortBy('order') as $filtermenu)
                                    <li><a class="dropdown-item"
                                            href="{{ route($filtermenu->route) }}">{{ $filtermenu->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </div>
            <i class="fas fa-ellipsis-vertical navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"></i>
        </div>

        <div class="collapse navbar-collapse nav-second" id="navbarSupportedContent">
            <div class="d-flex w-100 justify-content-between justify-content-md-end align-items-center">
                <div class="d-md-none">
                    <i class="fas fa-bars" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                        aria-controls="offcanvasRight"></i>
                </div>
                <div class="d-flex flex-wrap">
                    {{-- <div class="dropdown">
                        <div class="icon-border me-2 dropdown" type="button" id="bellIcon" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-bell text-primary pointer"></i>
                        </div>
                        <ul class="dropdown-menu p-0 shadow bg-transparent card-rounded" id="notificationdropdown">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Recent Notifications</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                    </ul>
                                </div>
                            </div>

                            <div class="w-100 h-100 d-flex justify-content-center align-items-center flex-column py-4">
                                <i class="text-primary fas fa-bell fa-3x mb-2"></i>
                                <span class="text-primary text-center">No Notifications</span>
                            </div>
                        </ul>
                    </div> --}}
                    <div class="icon-border me-2">
                        <a href="{{ route('clear.cache') }}" data-title="Cache Clear"
                            class="p-0 m-0 btn btn-none border-none align-items-center justify-content-center custom-tooltip">
                            <i class="fa-solid fa-brush pointer m-0 p-0 text-light"></i>
                        </a>
                    </div>
                    <div class="icon-border me-2">
                        <button
                            class=" p-0 m-0 btn btn-none border-none align-items-center justify-content-center custom-tooltip"
                            data-title="Change Mode">
                            <i class="fa-solid fa-moon pointer text-light m-0 p-0"type='submit' id="theme"></i>
                        </button>
                    </div>
                    <div class="dropdown me-2">
                        <div class="profile-img-nav" type="button" id="profileuserauth" data-bs-toggle="dropdown"
                            data-bs-target="profiledropdown" aria-expanded="false">
                            <img src="{{ asset('storage/' . auth()->user()->image ?? auth()->user()->img) }}"
                                onerror="this.src='{{ asset('storage/icons/user.png') }}'" class=""
                                alt="userimage">
                        </div>
                        <ul class="dropdown-menu shadow card-rounded bg-white" id="profiledropdown"
                            aria-labelledby="profileuserauth">
                            <div class="d-flex flex-wrap py-3 px-2">
                                <div class="image-user-sidebar shadow me-2">
                                    <img src="{{ asset('storage/' . auth()->user()->image ?? user()->img) }}"
                                        onerror="this.src='{{ asset('storage/icons/user.png') }}'" class="img-fluid"
                                        alt="userimage">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="font-1 text-dark font-bold text-uppercase">{{ user()->name ?? '' }}</span>
                                    <span
                                        class="text-dark font-075">{{auth()->user()->dflt == 1 ? 'Master Admin':(auth()->user()->roles->name ?? auth()->user()->name)}}</span>
                                    <span class="text-dark font-075"><i
                                            class="fa fa-envelope"></i>&nbsp;{{ user()->email ?? '' }}</span>
                                </div>
                                <hr class="p-0 m-0">
                            </div>

                            <div class="text-dark px-3">
                                <div class="">
                                    <li class="nav-item w-auto d-flex mb-2">
                                        <div class="icon-width w-auto">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <a class="nav-link fw-bold fs-6"  href="{{ route('admin.account') }}">Account</a>
                                    </li>
                                    @if (user()->instance() == 'admin' && user()->dflt == 1)
                                        <li class="nav-item w-auto d-flex mb-2">
                                            <div class="icon-width w-auto">
                                                <i class="fa-solid fa-gear"></i>
                                            </div>
                                            <a class="nav-link font-bold fs-6" href="{{ route('admin.setting') }}">Setting</a>
                                        </li>
                                    @endif

                                    {{-- <li class="nav-item w-auto d-flex mb-3">
                                        <div class="icon-width w-auto">
                                            <i class="fa-solid fa-bell"></i>
                                        </div>
                                        <a class="nav-link m-0" href="/admin/notifications">Notifications</a>
                                    </li> --}}
                                    <li
                                        class="btn btn-sub btn-rounded w-100 btn-md d-flex justify-content-center align-items-center">
                                        <a href="{{ route('logout') }}" class="text-dark text-decoration-none">
                                            <div class="text-light">
                                                <i class="fa-solid fa-right-from-bracket me-0 text-light"></i>&nbsp;Logout
                                            </div>
                                        </a>
                                    </li>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div class="icon-border me-2">
                        <a href="{{ route('logout') }}" data-title="Logout"
                            class="p-0 m-0 btn btn-none border-none align-items-center justify-content-center custom-tooltip">
                            <i class="fas fa-power-off me-0 text-light"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
