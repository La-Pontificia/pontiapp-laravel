<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('modulo') }}
            {{ Form::text('modulo', $acceso->modulo, ['class' => 'form-control' . ($errors->has('modulo') ? ' is-invalid' : ''), 'placeholder' => 'Modulo']) }}
            {!! $errors->first('modulo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('crear') }}
            {{ Form::text('crear', $acceso->crear, ['class' => 'form-control' . ($errors->has('crear') ? ' is-invalid' : ''), 'placeholder' => 'Crear']) }}
            {!! $errors->first('crear', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('leer') }}
            {{ Form::text('leer', $acceso->leer, ['class' => 'form-control' . ($errors->has('leer') ? ' is-invalid' : ''), 'placeholder' => 'Leer']) }}
            {!! $errors->first('leer', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('actualizar') }}
            {{ Form::text('actualizar', $acceso->actualizar, ['class' => 'form-control' . ($errors->has('actualizar') ? ' is-invalid' : ''), 'placeholder' => 'Actualizar']) }}
            {!! $errors->first('actualizar', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('eliminar') }}
            {{ Form::text('eliminar', $acceso->eliminar, ['class' => 'form-control' . ($errors->has('eliminar') ? ' is-invalid' : ''), 'placeholder' => 'Eliminar']) }}
            {!! $errors->first('eliminar', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        {{-- <div class="form-group">
            {{ Form::label('id_colaborador') }}
            {{ Form::text('id_colaborador', $acceso->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => 'Id Colaborador']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div> --}}

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>