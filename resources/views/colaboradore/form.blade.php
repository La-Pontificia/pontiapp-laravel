<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
            {{ Form::label('dni') }}
            {{ Form::text('dni', $colaboradore->dni, ['class' => 'form-control' . ($errors->has('dni') ? ' is-invalid' : '')]) }}
            {!! $errors->first('dni', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('apellidos') }}
            {{ Form::text('apellidos', $colaboradore->apellidos, ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : '')]) }}
            {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombres') }}
            {{ Form::text('nombres', $colaboradore->nombres, ['class' => 'form-control' . ($errors->has('nombres') ? ' is-invalid' : '')]) }}
            {!! $errors->first('nombres', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Cargo') }}
            {{ Form::select('id_cargo', $cargos, $colaboradore->id_cargo, ['class' => 'form-control' . ($errors->has('id_cargo') ? ' is-invalid' : '')]) }}
            {!! $errors->first('id_cargo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Puesto') }}
            {{ Form::select('id_puesto', $puestos, $colaboradore->id_puesto, ['class' => 'form-control' . ($errors->has('id_puesto') ? ' is-invalid' : '')]) }}
            {!! $errors->first('id_puesto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer" style="margin-top: 10px">
        <button type="submit" class="btn btn-primary" style="font-size: 16px;">{{ __('Guardar') }}</button>
    </div>
</div>
