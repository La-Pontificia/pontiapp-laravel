<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_objetivo') }}
            {{ Form::text('id_objetivo', $calificacione->id_objetivo, ['class' => 'form-control' . ($errors->has('id_objetivo') ? ' is-invalid' : ''), 'placeholder' => 'Id Objetivo']) }}
            {!! $errors->first('id_objetivo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_supervisor') }}
            {{ Form::text('id_supervisor', $calificacione->id_supervisor, ['class' => 'form-control' . ($errors->has('id_supervisor') ? ' is-invalid' : ''), 'placeholder' => 'Id Supervisor']) }}
            {!! $errors->first('id_supervisor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_aprobacion') }}
            {{ Form::text('fecha_aprobacion', $calificacione->fecha_aprobacion, ['class' => 'form-control' . ($errors->has('fecha_aprobacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Aprobacion']) }}
            {!! $errors->first('fecha_aprobacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('aprobado') }}
            {{ Form::text('aprobado', $calificacione->aprobado, ['class' => 'form-control' . ($errors->has('aprobado') ? ' is-invalid' : ''), 'placeholder' => 'Aprobado']) }}
            {!! $errors->first('aprobado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('pun_01') }}
            {{ Form::text('pun_01', $calificacione->pun_01, ['class' => 'form-control' . ($errors->has('pun_01') ? ' is-invalid' : ''), 'placeholder' => 'Pun 01']) }}
            {!! $errors->first('pun_01', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('eva_01') }}
            {{ Form::text('eva_01', $calificacione->eva_01, ['class' => 'form-control' . ($errors->has('eva_01') ? ' is-invalid' : ''), 'placeholder' => 'Eva 01']) }}
            {!! $errors->first('eva_01', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('apr_01') }}
            {{ Form::text('apr_01', $calificacione->apr_01, ['class' => 'form-control' . ($errors->has('apr_01') ? ' is-invalid' : ''), 'placeholder' => 'Apr 01']) }}
            {!! $errors->first('apr_01', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f_apr_01') }}
            {{ Form::text('f_apr_01', $calificacione->f_apr_01, ['class' => 'form-control' . ($errors->has('f_apr_01') ? ' is-invalid' : ''), 'placeholder' => 'F Apr 01']) }}
            {!! $errors->first('f_apr_01', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f_eva_01') }}
            {{ Form::text('f_eva_01', $calificacione->f_eva_01, ['class' => 'form-control' . ($errors->has('f_eva_01') ? ' is-invalid' : ''), 'placeholder' => 'F Eva 01']) }}
            {!! $errors->first('f_eva_01', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('c_01') }}
            {{ Form::text('c_01', $calificacione->c_01, ['class' => 'form-control' . ($errors->has('c_01') ? ' is-invalid' : ''), 'placeholder' => 'C 01']) }}
            {!! $errors->first('c_01', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('pun_02') }}
            {{ Form::text('pun_02', $calificacione->pun_02, ['class' => 'form-control' . ($errors->has('pun_02') ? ' is-invalid' : ''), 'placeholder' => 'Pun 02']) }}
            {!! $errors->first('pun_02', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('eva_02') }}
            {{ Form::text('eva_02', $calificacione->eva_02, ['class' => 'form-control' . ($errors->has('eva_02') ? ' is-invalid' : ''), 'placeholder' => 'Eva 02']) }}
            {!! $errors->first('eva_02', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('apr_02') }}
            {{ Form::text('apr_02', $calificacione->apr_02, ['class' => 'form-control' . ($errors->has('apr_02') ? ' is-invalid' : ''), 'placeholder' => 'Apr 02']) }}
            {!! $errors->first('apr_02', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f_apr_02') }}
            {{ Form::text('f_apr_02', $calificacione->f_apr_02, ['class' => 'form-control' . ($errors->has('f_apr_02') ? ' is-invalid' : ''), 'placeholder' => 'F Apr 02']) }}
            {!! $errors->first('f_apr_02', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f_eva_02') }}
            {{ Form::text('f_eva_02', $calificacione->f_eva_02, ['class' => 'form-control' . ($errors->has('f_eva_02') ? ' is-invalid' : ''), 'placeholder' => 'F Eva 02']) }}
            {!! $errors->first('f_eva_02', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('c_02') }}
            {{ Form::text('c_02', $calificacione->c_02, ['class' => 'form-control' . ($errors->has('c_02') ? ' is-invalid' : ''), 'placeholder' => 'C 02']) }}
            {!! $errors->first('c_02', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('c_eda') }}
            {{ Form::text('c_eda', $calificacione->c_eda, ['class' => 'form-control' . ($errors->has('c_eda') ? ' is-invalid' : ''), 'placeholder' => 'C Eda']) }}
            {!! $errors->first('c_eda', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('c_f_eda') }}
            {{ Form::text('c_f_eda', $calificacione->c_f_eda, ['class' => 'form-control' . ($errors->has('c_f_eda') ? ' is-invalid' : ''), 'placeholder' => 'C F Eda']) }}
            {!! $errors->first('c_f_eda', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>