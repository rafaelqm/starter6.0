@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        @permission('view.users')
        <li class="breadcrumb-item">
            <a href="{!! route('users.index') !!}">Usuários</a>
        </li>
        @endpermission
        <li class="breadcrumb-item active">Editar</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('coreui-templates::common.errors')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-edit fa-lg"></i>
                            <strong>
                                {{ $user->id == auth()->id() ? 'Meu Perfil' : 'Usuário '.$user->id }}

                                <small class="label label-default pull-right" title="Última atualização"
                                       data-toggle="tooltip">
                                    {{ $user->updated_at->format('d/m/Y H:i') }}
                                </small>
{{--                                <small class="label label-info pull-right" title="Último login" data-toggle="tooltip">--}}
{{--                                    {{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : '-' }}--}}
{{--                                </small>--}}

                            </strong>
                        </div>
                        <div class="card-body form-horizontal">
                            {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

                            @include('users.fields')

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
