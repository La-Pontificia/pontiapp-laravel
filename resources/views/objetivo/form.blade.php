
<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('colaborador') }}
            {{ Form::text('id_colaborador', $objetivo->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('objetivo') }}
            {{ Form::text('objetivo', $objetivo->objetivo, ['class' => 'form-control' . ($errors->has('objetivo') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('objetivo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('descripcion') }}
            {{ Form::text('descripcion', $objetivo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('porcentaje') }}
            {{ Form::text('porcentaje', $objetivo->porcentaje, ['class' => 'form-control' . ($errors->has('porcentaje') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('porcentaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('indicadores') }}
            {{ Form::text('indicadores', $objetivo->indicadores, ['class' => 'form-control' . ($errors->has('indicadores') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('indicadores', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_vencimiento') }}
            {{ Form::text('fecha_vencimiento', $objetivo->fecha_vencimiento, ['class' => 'form-control' . ($errors->has('fecha_vencimiento') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('fecha_vencimiento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        <div class="form-group">
            {{ Form::label('año_actividad') }}
            {{ Form::text('año_actividad', $objetivo->año_actividad, ['class' => 'form-control' . ($errors->has('año_actividad') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('año_actividad', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <br>
    <div class="box-footer mt20"> 

        <button type="submit" class="btn btn-primary">{{ __('Entregar') }}</button>
    </div>
</div>
