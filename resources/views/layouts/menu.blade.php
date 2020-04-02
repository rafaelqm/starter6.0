@permission('view.users')
<li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}">
        <i class="nav-icon icon-people"></i>
        <span>Usuários</span>
    </a>
</li>
@endpermission
@permission('roles.view')
<li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('roles.index') }}">
        <i class="nav-icon cil-wc"></i>
        <span>Papéis</span>
    </a>
</li>
@endpermission
