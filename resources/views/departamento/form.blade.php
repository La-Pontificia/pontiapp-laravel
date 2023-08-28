<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Código') }}
            {{ Form::text('codigo_departamento', $departamento->codigo_departamento, ['class' => 'form-control' . ($errors->has('codigo_departamento') ? ' is-invalid' : '')]) }}
            {!! $errors->first('codigo_departamento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('nombre_departamento', $departamento->nombre_departamento, ['class' => 'form-control' . ($errors->has('nombre_departamento') ? ' is-invalid' : '')]) }}
            {!! $errors->first('nombre_departamento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Area') }}
            {{ Form::select('id_area', $areas, $departamento->id_area, ['class' => 'form-control' . ($errors->has('id_area') ? ' is-invalid' : '')]) }}
            {!! $errors->first('id_area', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">{{ __('Crear') }}</button>
    </div>
</div>
