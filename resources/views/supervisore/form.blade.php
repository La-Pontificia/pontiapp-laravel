<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="form-group col-2">
            {{ Form::label('Colaborador') }}
            {{ Form::select('id_colaborador', $colabs, $supervisore->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : '')]) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-2">
            {{ Form::label('Supervisor') }}
            {{ Form::select('id_supervisor', $colabs, $supervisore->id_supervisor, ['class' => 'form-control' . ($errors->has('id_supervisor') ? ' is-invalid' : '')]) }}
            {!! $errors->first('id_supervisor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Guardar supervisor (Jefe Inmediato)') }}</button>
    </div>
</div>
