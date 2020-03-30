<div class="form-group row">
    <!-- Name Field -->
    <div class="col-sm-6">
        {!! Form::label('name', 'Nome:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>


    <!-- Email Field -->
    <div class="col-sm-6">
        {!! Form::label('email', 'E-mail:') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row">
    <!-- Password Field -->
    <div class="col-sm-6">
        {!! Form::label('password', 'Senha:') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    {{--Apenas SuperAdmin--}}
    @level(5)
    <!-- Active Field -->
    <div class="col-sm-6">
        {!! Form::label('active', 'Ativo:') !!}
        <div class="form-control text-center">
            <label class="c-switch c-switch-3d c-switch-success">
                {!! Form::hidden('active', false, ['id'=>'activehidden']) !!}
                {!! Form::checkbox('active', '1', null, ['class' => 'c-switch-input']) !!}
                <span class="c-switch-slider"></span>
            </label>

            <label class="checkbox-inline">

            </label>
        </div>
    </div>

</div>
<div class="form-group row">
    <!-- Active Field -->
    <div class="col-sm-12">
        {!! Form::label('roles', 'Papéis/Cargos:') !!}
        {!! Form::select(
            'roles[]',
            \jeremykenedy\LaravelRoles\Models\Role::where('active', 1)->pluck('name', 'id')->toArray(),
             null,
             [
                'class' => 'form-control select2',
                'multiple' => 'multiple'
             ]
             ) !!}
    </div>

    @endlevel
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary float-right">
        <i class="far fa-save"></i> {{ __('crud.save') }}
    </button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> {{ __('crud.cancel') }}
    </a>
</div>
