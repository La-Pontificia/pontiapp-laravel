<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('modulo') }}
            {{ Form::text('modulo', $acceso->modulo, ['class' => 'form-control' . ($errors->has('modulo') ? ' is-invalid' : ''), 'placeholder' => 'Modulo']) }}
            {!! $errors->first('modulo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('acceso') }}
            {{ Form::text('acceso', $acceso->acceso, ['class' => 'form-control' . ($errors->has('acceso') ? ' is-invalid' : ''), 'placeholder' => 'Acceso']) }}
            {!! $errors->first('acceso', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_colaborador') }}
            {{ Form::text('id_colaborador', $acceso->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => 'Id Colaborador']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>