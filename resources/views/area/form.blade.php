<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Código') }}
            {{ Form::text('codigo_area', $area->codigo_area, ['class' => 'form-control' . ($errors->has('codigo_area') ? ' is-invalid' : '')]) }}
            {!! $errors->first('codigo_area', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('nombre_area', $area->nombre_area, ['class' => 'form-control' . ($errors->has('nombre_area') ? ' is-invalid' : '')]) }}
            {!! $errors->first('nombre_area', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer ">
        <button type="submit" style="display: block; width: 100%; margin-top: 10px;"
            class="btn btn-primary">{{ __('Registrar') }}</button>
    </div>
</div>
