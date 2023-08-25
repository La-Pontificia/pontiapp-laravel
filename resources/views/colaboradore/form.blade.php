<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('dni') }}
            {{ Form::text('dni', $colaboradore->dni, ['class' => 'form-control' . ($errors->has('dni') ? ' is-invalid' : ''), 'placeholder' => 'Dni']) }}
            {!! $errors->first('dni', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('apellidos') }}
            {{ Form::text('apellidos', $colaboradore->apellidos, ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Apellidos']) }}
            {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombres') }}
            {{ Form::text('nombres', $colaboradore->nombres, ['class' => 'form-control' . ($errors->has('nombres') ? ' is-invalid' : ''), 'placeholder' => 'Nombres']) }}
            {!! $errors->first('nombres', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        {{-- <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $colaboradore->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div> --}}
        <div class="form-group">
            {{ Form::label('id_cargo') }}
            {{ Form::select('id_cargo', $cargos, $colaboradore->id_cargo, ['class' => 'form-control' . ($errors->has('id_cargo') ? ' is-invalid' : ''), 'placeholder' => 'Id Cargo']) }}
            {!! $errors->first('id_cargo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_puesto') }}
            {{ Form::select('id_puesto', $puestos, $colaboradore->id_puesto, ['class' => 'form-control' . ($errors->has('id_puesto') ? ' is-invalid' : ''), 'placeholder' => 'Id Puesto']) }}
            {!! $errors->first('id_puesto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        {{-- <div class="form-group">
            {{ Form::label('id_usuario') }}
            {{ Form::text('id_usuario', $colaboradore->id_usuario, ['class' => 'form-control' . ($errors->has('id_usuario') ? ' is-invalid' : ''), 'placeholder' => 'Id Usuario']) }}
            {!! $errors->first('id_usuario', '<div class="invalid-feedback">:message</div>') !!}
        </div> --}}
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
