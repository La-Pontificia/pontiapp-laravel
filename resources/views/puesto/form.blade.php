<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('codigo_puesto') }}
            {{ Form::text('codigo_puesto', $puesto->codigo_puesto, ['class' => 'form-control' . ($errors->has('codigo_puesto') ? ' is-invalid' : ''), 'placeholder' => 'Codigo Puesto']) }}
            {!! $errors->first('codigo_puesto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre_puesto') }}
            {{ Form::text('nombre_puesto', $puesto->nombre_puesto, ['class' => 'form-control' . ($errors->has('nombre_puesto') ? ' is-invalid' : ''), 'placeholder' => 'Nombre Puesto']) }}
            {!! $errors->first('nombre_puesto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_departamento') }}
            {{ Form::text('id_departamento', $puesto->id_departamento, ['class' => 'form-control' . ($errors->has('id_departamento') ? ' is-invalid' : ''), 'placeholder' => 'Id Departamento']) }}
            {!! $errors->first('id_departamento', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>