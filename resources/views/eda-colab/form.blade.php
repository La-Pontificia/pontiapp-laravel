<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_eda') }}
            {{ Form::text('id_eda', $edaColab->id_eda, ['class' => 'form-control' . ($errors->has('id_eda') ? ' is-invalid' : ''), 'placeholder' => 'Id Eda']) }}
            {!! $errors->first('id_eda', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_colaborador') }}
            {{ Form::text('id_colaborador', $edaColab->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => 'Id Colaborador']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $edaColab->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cant_obj') }}
            {{ Form::text('cant_obj', $edaColab->cant_obj, ['class' => 'form-control' . ($errors->has('cant_obj') ? ' is-invalid' : ''), 'placeholder' => 'Cant Obj']) }}
            {!! $errors->first('cant_obj', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nota_final') }}
            {{ Form::text('nota_final', $edaColab->nota_final, ['class' => 'form-control' . ($errors->has('nota_final') ? ' is-invalid' : ''), 'placeholder' => 'Nota Final']) }}
            {!! $errors->first('nota_final', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('wearing') }}
            {{ Form::text('wearing', $edaColab->wearing, ['class' => 'form-control' . ($errors->has('wearing') ? ' is-invalid' : ''), 'placeholder' => 'Wearing']) }}
            {!! $errors->first('wearing', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f_envio') }}
            {{ Form::text('f_envio', $edaColab->f_envio, ['class' => 'form-control' . ($errors->has('f_envio') ? ' is-invalid' : ''), 'placeholder' => 'F Envio']) }}
            {!! $errors->first('f_envio', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f_aprobacion') }}
            {{ Form::text('f_aprobacion', $edaColab->f_aprobacion, ['class' => 'form-control' . ($errors->has('f_aprobacion') ? ' is-invalid' : ''), 'placeholder' => 'F Aprobacion']) }}
            {!! $errors->first('f_aprobacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f_cerrado') }}
            {{ Form::text('f_cerrado', $edaColab->f_cerrado, ['class' => 'form-control' . ($errors->has('f_cerrado') ? ' is-invalid' : ''), 'placeholder' => 'F Cerrado']) }}
            {!! $errors->first('f_cerrado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('flimit_send_obj_from') }}
            {{ Form::text('flimit_send_obj_from', $edaColab->flimit_send_obj_from, ['class' => 'form-control' . ($errors->has('flimit_send_obj_from') ? ' is-invalid' : ''), 'placeholder' => 'Flimit Send Obj From']) }}
            {!! $errors->first('flimit_send_obj_from', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('flimit_send_obj_at') }}
            {{ Form::text('flimit_send_obj_at', $edaColab->flimit_send_obj_at, ['class' => 'form-control' . ($errors->has('flimit_send_obj_at') ? ' is-invalid' : ''), 'placeholder' => 'Flimit Send Obj At']) }}
            {!! $errors->first('flimit_send_obj_at', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('flimit_white_autoeva_from') }}
            {{ Form::text('flimit_white_autoeva_from', $edaColab->flimit_white_autoeva_from, ['class' => 'form-control' . ($errors->has('flimit_white_autoeva_from') ? ' is-invalid' : ''), 'placeholder' => 'Flimit White Autoeva From']) }}
            {!! $errors->first('flimit_white_autoeva_from', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('flimit_white_autoeva_at') }}
            {{ Form::text('flimit_white_autoeva_at', $edaColab->flimit_white_autoeva_at, ['class' => 'form-control' . ($errors->has('flimit_white_autoeva_at') ? ' is-invalid' : ''), 'placeholder' => 'Flimit White Autoeva At']) }}
            {!! $errors->first('flimit_white_autoeva_at', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>