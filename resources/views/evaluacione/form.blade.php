<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('promedio') }}
            {{ Form::text('promedio', $evaluacione->promedio, ['class' => 'form-control' . ($errors->has('promedio') ? ' is-invalid' : ''), 'placeholder' => 'Promedio']) }}
            {!! $errors->first('promedio', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('autocalificacion') }}
            {{ Form::text('autocalificacion', $evaluacione->autocalificacion, ['class' => 'form-control' . ($errors->has('autocalificacion') ? ' is-invalid' : ''), 'placeholder' => 'Autocalificacion']) }}
            {!! $errors->first('autocalificacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cerrado') }}
            {{ Form::text('cerrado', $evaluacione->cerrado, ['class' => 'form-control' . ($errors->has('cerrado') ? ' is-invalid' : ''), 'placeholder' => 'Cerrado']) }}
            {!! $errors->first('cerrado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_promedio') }}
            {{ Form::text('fecha_promedio', $evaluacione->fecha_promedio, ['class' => 'form-control' . ($errors->has('fecha_promedio') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Promedio']) }}
            {!! $errors->first('fecha_promedio', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_autocalificacion') }}
            {{ Form::text('fecha_autocalificacion', $evaluacione->fecha_autocalificacion, ['class' => 'form-control' . ($errors->has('fecha_autocalificacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Autocalificacion']) }}
            {!! $errors->first('fecha_autocalificacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_cerrado') }}
            {{ Form::text('fecha_cerrado', $evaluacione->fecha_cerrado, ['class' => 'form-control' . ($errors->has('fecha_cerrado') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Cerrado']) }}
            {!! $errors->first('fecha_cerrado', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>