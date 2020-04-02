<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-4">
    {!! Form::label('description', 'Descrição:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Level Field -->
<div class="form-group col-sm-4">
    {!! Form::label('level', 'Nível:') !!}
    {!! Form::select('level', \App\Role::NIVEIS , null, ['class' => 'form-control select2', 'required']) !!}
</div>

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

<!-- Roles Field -->
<div class="form-group col-sm-12">
    {!! Form::label('permissions', 'Permissões:') !!}
    {!! Form::select(
        'permissions[]',
        \App\Permission::orderBy('slug')->pluck('name', 'id')->toArray(),
         null,
         [
            'class' => 'form-control select2',
            'multiple' => 'multiple'
         ]
         ) !!}
</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary float-right">
        <i class="far fa-save"></i> Salvar
    </button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>
