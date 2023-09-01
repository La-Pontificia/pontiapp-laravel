{{-- <div class="box box-info padding-1">

    <div class="box-body row ">

        <div class="form-group">
            {{ Form::label('colaborador') }}
            {{ Form::text('id_colaborador', $objetivo->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-3">
            {{ Form::label('objetivo') }}
            {{ Form::textarea('objetivo', $objetivo->objetivo, ['class' => 'form-control ' . ($errors->has('objetivo') ? ' is-invalid' : ''), 'rows' => 4, 'placeholder' => '']) }}
            {!! $errors->first('objetivo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-3">
            {{ Form::label('descripcion') }}
            {{ Form::textarea('descripcion', $objetivo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'rows' => 4, 'placeholder' => '']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-3">
            {{ Form::label('Porcentaje %') }}
            {{ Form::number('porcentaje', $objetivo->porcentaje, ['class' => 'form-control' . ($errors->has('porcentaje') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('porcentaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-3">
            {{ Form::label('indicadores') }}
            {{ Form::textarea('indicadores', $objetivo->indicadores, ['class' => 'form-control' . ($errors->has('indicadores') ? ' is-invalid' : ''), 'rows' => 4, 'placeholder' => '']) }}
            {!! $errors->first('indicadores', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f. venc') }}
            {{ Form::date('fecha_vencimiento', $objetivo->fecha_vencimiento, ['class' => 'form-control' . ($errors->has('fecha_vencimiento') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('fecha_vencimiento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <br>
    <div class="box-footer mt20">

        <button type="submit" class="btn btn-primary">{{ __('Entregar') }}</button>
    </div>
</div> --}}

<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('id_colaborador') }}
            {{ Form::text('id_colaborador', $objetivo->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => 'Id Colaborador']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('objetivo') }}
            {{ Form::text('objetivo', $objetivo->objetivo, ['class' => 'form-control' . ($errors->has('objetivo') ? ' is-invalid' : ''), 'placeholder' => 'Objetivo']) }}
            {!! $errors->first('objetivo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('descripcion') }}
            {{ Form::text('descripcion', $objetivo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('porcentaje') }}
            {{ Form::number('porcentaje', $objetivo->porcentaje, ['class' => 'form-control' . ($errors->has('porcentaje') ? ' is-invalid' : ''), 'placeholder' => 'Porcentaje']) }}
            {!! $errors->first('porcentaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('indicadores') }}
            {{ Form::textarea('indicadores', $objetivo->indicadores, ['class' => 'form-control' . ($errors->has('indicadores') ? ' is-invalid' : ''), 'placeholder' => 'Indicadores']) }}
            {!! $errors->first('indicadores', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_vencimiento') }}
            {{ Form::date('fecha_vencimiento', $objetivo->fecha_vencimiento, ['class' => 'form-control' . ($errors->has('fecha_vencimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Vencimiento']) }}
            {!! $errors->first('fecha_vencimiento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('puntaje_01') }}
            {{ Form::number('puntaje_01', $objetivo->puntaje_01, ['class' => 'form-control' . ($errors->has('puntaje_01') ? ' is-invalid' : ''), 'placeholder' => 'Puntaje 01']) }}
            {!! $errors->first('puntaje_01', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_calificacion_1') }}
            {{ Form::date('fecha_calificacion_1', $objetivo->fecha_calificacion_1, ['class' => 'form-control' . ($errors->has('fecha_calificacion_1') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Calificacion 1']) }}
            {!! $errors->first('fecha_calificacion_1', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_aprobacion_1') }}
            {{ Form::date('fecha_aprobacion_1', $objetivo->fecha_aprobacion_1, ['class' => 'form-control' . ($errors->has('fecha_aprobacion_1') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Aprobacion 1']) }}
            {!! $errors->first('fecha_aprobacion_1', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('puntaje_02') }}
            {{ Form::number('puntaje_02', $objetivo->puntaje_02, ['class' => 'form-control' . ($errors->has('puntaje_02') ? ' is-invalid' : ''), 'placeholder' => 'Puntaje 02']) }}
            {!! $errors->first('puntaje_02', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_calificacion_2') }}
            {{ Form::date('fecha_calificacion_2', $objetivo->fecha_calificacion_2, ['class' => 'form-control' . ($errors->has('fecha_calificacion_2') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Calificacion 2']) }}
            {!! $errors->first('fecha_calificacion_2', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_aprobacion_2') }}
            {{ Form::date('fecha_aprobacion_2', $objetivo->fecha_aprobacion_2, ['class' => 'form-control' . ($errors->has('fecha_aprobacion_2') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Aprobacion 2']) }}
            {!! $errors->first('fecha_aprobacion_2', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('aprobado') }}
            {{ Form::number('aprobado', $objetivo->aprobado, ['class' => 'form-control' . ($errors->has('aprobado') ? ' is-invalid' : ''), 'placeholder' => 'Aprobado']) }}
            {!! $errors->first('aprobado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('aprovado_ev_1') }}
            {{ Form::number('aprovado_ev_1', $objetivo->aprovado_ev_1, ['class' => 'form-control' . ($errors->has('aprovado_ev_1') ? ' is-invalid' : ''), 'placeholder' => 'Aprovado Ev 1']) }}
            {!! $errors->first('aprovado_ev_1', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('aprovado_ev_2') }}
            {{ Form::number('aprovado_ev_2', $objetivo->aprovado_ev_2, ['class' => 'form-control' . ($errors->has('aprovado_ev_2') ? ' is-invalid' : ''), 'placeholder' => 'Aprovado Ev 2']) }}
            {!! $errors->first('aprovado_ev_2', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('año_actividad') }}
            {{ Form::date('año_actividad', $objetivo->año_actividad, ['class' => 'form-control' . ($errors->has('año_actividad') ? ' is-invalid' : ''), 'placeholder' => 'Año Actividad']) }}
            {!! $errors->first('año_actividad', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
