<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('codigo_departamento') }}
            {{ Form::text('codigo_departamento', $departamento->codigo_departamento, ['class' => 'form-control' . ($errors->has('codigo_departamento') ? ' is-invalid' : ''), 'placeholder' => 'Codigo Departamento']) }}
            {!! $errors->first('codigo_departamento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre_departamento') }}
            {{ Form::text('nombre_departamento', $departamento->nombre_departamento, ['class' => 'form-control' . ($errors->has('nombre_departamento') ? ' is-invalid' : ''), 'placeholder' => 'Nombre Departamento']) }}
            {!! $errors->first('nombre_departamento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_area') }}
            {{ Form::text('id_area', $departamento->id_area, ['class' => 'form-control' . ($errors->has('id_area') ? ' is-invalid' : ''), 'placeholder' => 'Id Area']) }}
            {!! $errors->first('id_area', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>