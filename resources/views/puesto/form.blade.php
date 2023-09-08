<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Codigo') }}
            {{ Form::text('codigo_puesto', $puesto->codigo_puesto, ['class' => 'form-control' . ($errors->has('codigo_puesto') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('codigo_puesto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('nombre_puesto', $puesto->nombre_puesto, ['class' => 'form-control' . ($errors->has('nombre_puesto') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('nombre_puesto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Departamento') }}
            {{ Form::select('id_departamento', $depas, $puesto->id_departamento, ['class' => 'form-control' . ($errors->has('id_departamento') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona un opcion']) }}
            {!! $errors->first('id_departamento', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Registrar') }}</button>
    </div>
</div>
