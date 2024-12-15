@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <style>
        .loader {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-top-color: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;

        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    @php
        $menuMapFirst = false;
        $menuMapSecond = false;
        $menuMapThird = false;
        $menuMapFourth = false;
        $menuMapFifth = false;
        $submenuMapFirst = false;
        $submenuMapSecond = false;
        $submenuMapThird = false;
        $submenuMapFourth = false;
        $submenuMapFifth = false;
        $userPermission = user()->permissions;
        $userPermission = user()->permissions->where('user_type', user()->instance());
        $menus = menu();
        if (user()->dflt == 1 && user()->instance() == 'admin') {
            $master = true;
        } else {
            $master = '';
        }
        if ($data) {
            $pr = $data->permissions->where('user_type', $data->instance());
        } else {
            $pr = [];
        }
        $mapping = [];
    @endphp

    <div class="">
        <div class="mb-2">
            <x-back />
        </div>
        <x-form-view title="Permissions">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Read</th>
                            <th>Write</th>
                            <th>Update</th>
                            <th>Delete</th>
                            <th>Rights</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus->sortBy('order')->where('dflt', false) as $menu)
                            @foreach ($permissionMap->whereNotNull('menu_id') as $permission)
                                @php
                                    $menuIds = explode(',', $permission->menu_id);
                                    if (in_array($menu->id, $menuIds)) {
                                        switch ($permission->menu_map) {
                                            case 1:
                                                $menuMapFirst[$menu->id] = true;
                                                break;
                                            case 2:
                                                $menuMapSecond[$menu->id] = true;
                                                break;
                                            case 3:
                                                $menuMapThird[$menu->id] = true;
                                                break;
                                            case 4:
                                                $menuMapFourth[$menu->id] = true;
                                                break;
                                            case 5:
                                                $menuMapFifth[$menu->id] = true;
                                                break;
                                        }
                                    }
                                @endphp
                            @endforeach
                            @php
                                // Assuming $userPermission is a query builder or model query
                                $menuPermission = $userPermission->where('mid', $menu->id)->first();
                                $prm = collect($pr)->firstWhere('mid', $menu->id);
                            @endphp
                            <tr>
                                <td><i class="{{ $menu->icon }} text-primary"></i>&nbsp;{{ $menu->name }}</td>
                                <td>
                                    @if ($menuMapFirst[$menu->id] ?? false)
                                        <div class="form-check">
                                            <input class="" type="checkbox" data-type="read"
                                                data-id="{{ $menu->id }}" data-menu="mid"
                                                value="{{ $menu->id }}_read" id="menu_{{ $menu->id }}_read"
                                                {{ $prm && $prm->read == true ? 'checked' : '' }}>
                                            <label class="form-check-label" for="menu_{{ $menu->id }}_read"></label>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($menuMapSecond[$menu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['write'] == true) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox" value="{{ $menu->id }}_write"
                                                    data-type="write" data-id="{{ $menu->id }}" data-menu="mid"
                                                    id="menu_{{ $menu->id }}_write"
                                                    {{ $prm && $prm->write == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="menu_{{ $menu->id }}_write"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($menuMapThird[$menu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['update'] == true) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox" value="{{ $menu->id }}_update"
                                                    id="menu_{{ $menu->id }}_update" data-type="update"
                                                    data-id="{{ $menu->id }}" data-menu="mid"
                                                    {{ $prm && $prm->update == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="menu_{{ $menu->id }}_update"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($menuMapFourth[$menu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['delete'] == true) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox" value="{{ $menu->id }}_delete"
                                                    id="menu_{{ $menu->id }}_delete" data-type="delete"
                                                    data-id="{{ $menu->id }}" data-menu="mid"
                                                    {{ $prm && $prm->delete == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="menu_{{ $menu->id }}_delete"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($menuMapFifth[$menu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['rights'] == true) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox"
                                                    value="sub_{{ $menu->id }}_rights"
                                                    id="menu_{{ $menu->id }}_rights" data-type="rights"
                                                    data-id="{{ $menu->id }}" data-menu="mid"
                                                    {{ $prm && $prm->rights == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="menu_{{ $menu->id }}_rights"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
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
                                @foreach ($filteredMenus as $submenu)
                                    @foreach ($permissionMap->whereNotNull('submenu_id') as $permission)
                                        @php
                                            $menuIds = explode(',', $permission->submenu_id);
                                            if (in_array($submenu->id, $menuIds)) {
                                                switch ($permission->submenu_map) {
                                                    case 1:
                                                        $submenuMapFirst[$submenu->id] = true;
                                                        break;
                                                    case 2:
                                                        $submenuMapSecond[$submenu->id] = true;
                                                        break;
                                                    case 3:
                                                        $submenuMapThird[$submenu->id] = true;
                                                        break;
                                                    case 4:
                                                        $submenuMapFourth[$submenu->id] = true;
                                                        break;
                                                    case 5:
                                                        $submenuMapFifth[$submenu->id] = true;
                                                        break;
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    @php
                                        $menuPermission = collect($userPermission)->firstWhere('subid', $submenu->id);
                                        $prm = collect($pr)->firstWhere('subid', $submenu->id);
                                    @endphp
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $submenu->name }}</td>
                                        <td>
                                            @if ($submenuMapFirst[$submenu->id] ?? false)
                                                @if (($menuPermission && $menuPermission['read'] == true) || $master)
                                                    <div class="form-check">
                                                        <input class="" type="checkbox"
                                                            value="sub_{{ $submenu->id }}_read"
                                                            id="permission_{{ $submenu->id }}_read" data-type="read"
                                                            data-id="{{ $submenu->id }}" data-menu="subid"
                                                            {{ $prm && $prm->read == true ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission_{{ $submenu->id }}_read"></label>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($submenuMapSecond[$submenu->id] ?? false)
                                                @if (($menuPermission && $menuPermission['write'] == true) || $master)
                                                    <div class="form-check">
                                                        <input class="" type="checkbox"
                                                            value="sub_{{ $submenu->id }}_write"
                                                            id="permission_{{ $submenu->id }}_write" data-type="write"
                                                            data-id="{{ $submenu->id }}" data-menu="subid"
                                                            {{ $prm && $prm->write == true ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission_{{ $submenu->id }}_write"></label>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($submenuMapThird[$submenu->id] ?? false)
                                                @if (($menuPermission && $menuPermission['update'] == true) || $master)
                                                    <div class="form-check">
                                                        <input class="" type="checkbox"
                                                            value="sub_{{ $submenu->id }}_update"
                                                            id="permission_{{ $submenu->id }}_update" data-type="update"
                                                            data-id="{{ $submenu->id }}" data-menu="subid"
                                                            {{ $prm && $prm->update == true ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission_{{ $submenu->id }}_update"></label>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($submenuMapFourth[$submenu->id] ?? false)
                                                @if (($menuPermission && $menuPermission['delete'] == true) || $master)
                                                    <div class="form-check">
                                                        <input class="" type="checkbox"
                                                            value="sub_{{ $submenu->id }}_delete"
                                                            id="permission_{{ $submenu->id }}_delete" data-type="delete"
                                                            data-id="{{ $submenu->id }}" data-menu="subid"
                                                            {{ $prm && $prm->delete == true ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission_{{ $submenu->id }}_delete"></label>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($submenuMapFifth[$submenu->id] ?? false)
                                                @if (($menuPermission && $menuPermission['rights'] == true) || $master)
                                                    <div class="form-check">
                                                        <input class="" type="checkbox"
                                                            value="sub_{{ $menu->id }}_rights"
                                                            id="menu_{{ $menu->id }}_rights" data-type="rights"
                                                            data-id="{{ $submenu->id }}" data-menu="subid"
                                                            {{ $prm && $prm->rights == true ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="menu_{{ $menu->id }}_rights"></label>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        @php
                            $menus = sidemenu();
                        @endphp
                        @foreach ($menus->sortBy('order') as $menu)
                            @foreach ($permissionMap->whereNotNull('menu_id') as $permission)
                                @php
                                    $menuIds = explode(',', $permission->menu_id);
                                    if (in_array($menu->id, $menuIds)) {
                                        switch ($permission->menu_map) {
                                            case 1:
                                                $menuMapFirst[$menu->id] = true;
                                                break;
                                            case 2:
                                                $menuMapSecond[$menu->id] = true;
                                                break;
                                            case 3:
                                                $menuMapThird[$menu->id] = true;
                                                break;
                                            case 4:
                                                $menuMapFourth[$menu->id] = true;
                                                break;
                                            case 5:
                                                $menuMapFifth[$menu->id] = true;
                                                break;
                                        }
                                    }
                                @endphp
                            @endforeach
                            @php
                                $menuPermission = collect($userPermission)->firstWhere([
                                    'mid' => $menu->id,
                                ]);
                                $prm = collect($pr)->firstWhere('mid', $menu->id);
                            @endphp
                            <tr>
                                <td><i class="{{ $menu->icon }} text-primary"></i>&nbsp;{{ $menu->name }}</td>
                                <td>
                                    @if ($menuMapFirst[$menu->id] ?? false)
                                        <div class="form-check">
                                            <input class="" type="checkbox" value="{{ $menu->id }}_read"
                                                id="menu_{{ $menu->id }}_read" data-type="read"
                                                data-id="{{ $menu->id }}" data-menu="mid"
                                                {{ $prm && $prm->read == true ? 'checked' : '' }}>
                                            <label class="form-check-label" for="menu_{{ $menu->id }}_read"></label>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($menuMapSecond[$menu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['write'] == 1) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox" value="{{ $menu->id }}_write"
                                                    id="menu_{{ $menu->id }}_write" data-type="write"
                                                    data-id="{{ $menu->id }}" data-menu="mid"
                                                    {{ $prm && $prm->write == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="menu_{{ $menu->id }}_write"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($menuMapThird[$menu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['update'] == 1) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox" value="{{ $menu->id }}_update"
                                                    id="menu_{{ $menu->id }}_update" data-type="update"
                                                    data-id="{{ $menu->id }}" data-menu="mid"
                                                    {{ $prm && $prm->update == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="menu_{{ $menu->id }}_update"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($menuMapFourth[$menu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['delete'] == 1) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox" value="{{ $menu->id }}_delete"
                                                    id="menu_{{ $menu->id }}_delete" data-type="delete"
                                                    data-id="{{ $menu->id }}" data-menu="mid"
                                                    {{ $prm && $prm->delete == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="menu_{{ $menu->id }}_delete"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td></td>
                            </tr>
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
                                @foreach ($filteredMenus as $submenu)
                                    @foreach ($permissionMap->whereNotNull('submenu_id') as $permission)
                                        @php
                                            $menuIds = explode(',', $permission->submenu_id);
                                            if (in_array($submenu->id, $menuIds)) {
                                                switch ($permission->submenu_map) {
                                                    case 1:
                                                        $submenuMapFirst[$submenu->id] = true;
                                                        break;
                                                    case 2:
                                                        $submenuMapSecond[$submenu->id] = true;
                                                        break;
                                                    case 3:
                                                        $submenuMapThird[$submenu->id] = true;
                                                        break;
                                                    case 4:
                                                        $submenuMapFourth[$submenu->id] = true;
                                                        break;
                                                    case 5:
                                                        $submenuMapFifth[$submenu->id] = true;
                                                        break;
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                    @php
                                        $menuPermission = collect($userPermission)->firstWhere('subid', $submenu->id);
                                        $prm = collect($pr)->firstWhere('subid', $submenu->id);
                                    @endphp
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $submenu->name }}</td>
                                        <td>
                                            @if ($submenuMapFirst[$submenu->id] ?? false)
                                                @if (($menuPermission && $menuPermission['read'] == true) || $master)
                                                    <div class="form-check">
                                                        <input class="" type="checkbox"
                                                            value="sub_{{ $submenu->id }}_read"
                                                            id="permission_{{ $submenu->id }}_read" data-type="read"
                                                            data-id="{{ $submenu->id }}" data-menu="subid"
                                                            {{ $prm && $prm->read == true ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission_{{ $submenu->id }}_read"></label>
                                                    </div>
                                                @endif
                                        </td>
                                @endif
                                <td>
                                    @if ($submenuMapSecond[$submenu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['write'] == true) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox"
                                                    value="sub_{{ $submenu->id }}_write"
                                                    id="permission_{{ $submenu->id }}_write" data-type="write"
                                                    data-id="{{ $submenu->id }}" data-menu="subid"
                                                    {{ $prm && $prm->write == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="permission_{{ $submenu->id }}_write"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($submenuMapThird[$submenu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['update'] == true) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox"
                                                    value="sub_{{ $submenu->id }}_update"
                                                    id="permission_{{ $submenu->id }}_update" data-type="update"
                                                    data-id="{{ $submenu->id }}" data-menu="subid"
                                                    {{ $prm && $prm->update == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="permission_{{ $submenu->id }}_update"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($submenuMapFourth[$submenu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['delete'] == true) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox"
                                                    value="sub_{{ $submenu->id }}_delete"
                                                    id="permission_{{ $submenu->id }}_delete" data-type="delete"
                                                    data-id="{{ $submenu->id }}" data-menu="subid"
                                                    {{ $prm && $prm->delete == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="permission_{{ $submenu->id }}_delete"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($submenuMapFifth[$submenu->id] ?? false)
                                        @if (($menuPermission && $menuPermission['rights'] == true) || $master)
                                            <div class="form-check">
                                                <input class="" type="checkbox"
                                                    value="sub_{{ $submenu->id }}_rights"
                                                    id="menu_{{ $submenu->id }}_rights" data-type="rights"
                                                    data-id="{{ $submenu->id }}" data-menu="subid"
                                                    {{ $prm && $prm->rights == true ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="menu_{{ $submenu->id }}_rights"></label>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                </tr>
                            @endforeach
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-form-view>
    </div>
@endsection
@section('script')
    @if (check() && user()->hasPermission('rights'))
        <script>
            $(document).ready(function() {
                $('input[type="checkbox"][data-type]').change(function() {
                    var dataType = $(this).data('type');
                    var dataId = $(this).data('id');
                    var dataMenu = $(this).data('menu');
                    var checked = $(this).prop('checked') ? 1 : 0;
                    var uid = {{ $data->id }};
                    var instance = '{{ $data->instance() }}';
                    var requestData = {
                        type: dataType,
                        id: dataId,
                        checked: checked,
                        menu: dataMenu,
                        token_: token,
                        uid: uid,
                        instance: instance,
                    };
                    var parentTd = $(this).closest('td');
                    parentTd.css('display', 'flex')
                    parentTd.append('<div class="loader"></div>');
                    $.ajax({
                        url: '{{ route('admin.Permissions') }}',
                        type: 'POST',
                        data: requestData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Include CSRF token
                        },
                        success: function(response) {
                            $('.loader', parentTd).remove();
                            parentTd.css('display', '')
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                            $('.loader', parentTd).remove();
                            parentTd.css('display', '')

                        }
                    });
                });
            });
        </script>
    @endif
@endsection
