<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/">
        <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>
</li>
@can('ver-usuario')
<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}">
        <i class=" fas fa-building"></i><span>Usuarios</span>
    </a>
</li>
@endcan
@can('ver-rol')
<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('roles.index') }}">
        <i class=" fas fa-building"></i><span>Roles</span>
    </a>
</li>
@endcan
@can('ver-permiso')
<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('permisos.index') }}">
        <i class=" fas fa-building"></i><span>Permisos</span>
    </a>
</li>
@endcan
@can('ver-socios')
<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('socios.index') }}">
        <i class=" fas fa-building"></i><span>Socios de Negocio</span>
    </a>
</li>
@endcan