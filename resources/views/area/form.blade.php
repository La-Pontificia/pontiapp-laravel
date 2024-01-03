<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Código') }}
            {{ Form::text('codigo', $area->codigo, ['class' => 'form-control' . ($errors->has('codigo') ? ' is-invalid' : '')]) }}
            {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Nombre') }}
            {{ Form::text('nombre', $area->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : '')]) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer ">
        <button type="submit" style="display: block; width: 100%; margin-top: 10px;"
            class="btn btn-primary">{{ __('Registrar') }}</button>
    </div>
</div>
