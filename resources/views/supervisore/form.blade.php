<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_colaborador') }}
            {{ Form::text('id_colaborador', $supervisore->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => 'Id Colaborador']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_supervisor') }}
            {{ Form::text('id_supervisor', $supervisore->id_supervisor, ['class' => 'form-control' . ($errors->has('id_supervisor') ? ' is-invalid' : ''), 'placeholder' => 'Id Supervisor']) }}
            {!! $errors->first('id_supervisor', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>