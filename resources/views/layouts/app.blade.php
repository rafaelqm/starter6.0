<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{asset('css/custom-data-table.css')}}">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<div id="app"></div>
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="http://infyom.com/images/logo/blue_logo_150x150.jpg" width="30" height="30"
             alt="InfyOm Logo">
        <img class="navbar-brand-minimized" src="http://infyom.com/images/logo/blue_logo_150x150.jpg" width="30"
             height="30" alt="Infyom Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#">
                <i class="icon-bell"></i>
                <span class="badge badge-pill badge-danger">5</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" style="margin-right: 10px" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
                {!! Auth::user()->name !!}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-envelope-o"></i> Messages
                    <span class="badge badge-success">42</span>
                </a>
                <div class="dropdown-header text-center">
                    <strong>Settings</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-wrench"></i> Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-shield"></i> Lock Account</a>
                <a class="dropdown-item" href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i>Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
</header>

<div class="app-body">
    @include('layouts.sidebar')
    <main class="main">
        @yield('content')
    </main>
</div>
<footer class="app-footer">
    <div>
        <a href="#">Starter!</a>

        <span> <i class="cil-3d"></i>{{ date('Y') }}</span>
    </div>
    <div class="ml-auto">
        <span>Powered by</span>
        <i class="fas fa-archway"></i>
        <a href="https://studiobravo.com.br">StudioBravo!</a>
    </div>
</footer>
</body>

<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/global_inits.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
@yield('scripts')
<script type="text/javascript">
    function askDelete(id, route) {
        swal({
            title: "{{ ucfirst( __('crud.are_you_sure') ) }}?",
            text: "{{ ucfirst( __('crud.you-will-not-be-able-to-recover-this-registry') ) }}!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "{{ ucfirst( __('crud.cancel') ) }}",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "{{ ucfirst( __('crud.yes') ) }}, {{ ucfirst( __('crud.delete') ) }}!",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
            },
            dangerMode: true
        })
        .then(function (willDelete) {
            if (willDelete) {
                sureDelete(id, route);
            }
        });
    }
    function sureDelete(id, route) {
        $.post(route, {
            'id' : id,
            "_method": "DELETE",
            '_token' : $('meta[name="csrf-token"]').attr('content'),
            type: "POST"
        }).done(function(retorno) {
            swal('{{ ucfirst( __('crud.deleted') ) }}', '', 'success');
            window.LaravelDataTables["dataTableBuilder"].draw(false);
        }).fail(function(response) {
            var text = response.responseJSON ? response.responseJSON.error : false;
            var link = response.responseJSON ? response.responseJSON.link_option : false;
            var type = response.responseJSON ? response.responseJSON.type : false;

            var options = {
                title: '',
                text: text || 'Error',
                type: type || 'error'
            };

            swal(options)
            .then(function(isConfirm) {
                if(!isConfirm && link && link.length) {
                    location.href = link;
                }
            });
        });
    }
</script>
</html>
