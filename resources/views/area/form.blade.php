<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('codigo_area') }}
            {{ Form::text('codigo_area', $area->codigo_area, ['class' => 'form-control' . ($errors->has('codigo_area') ? ' is-invalid' : ''), 'placeholder' => 'Codigo Area']) }}
            {!! $errors->first('codigo_area', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre_area') }}
            {{ Form::text('nombre_area', $area->nombre_area, ['class' => 'form-control' . ($errors->has('nombre_area') ? ' is-invalid' : ''), 'placeholder' => 'Nombre Area']) }}
            {!! $errors->first('nombre_area', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>