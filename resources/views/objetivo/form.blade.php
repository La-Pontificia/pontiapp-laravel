<div class="box box-info padding-1">
    <div class="box-body row ">
        <div class="form-group col-2">
            {{ Form::label('objetivo') }}
            {{ Form::textarea('objetivo', $objetivo->objetivo, ['class' => 'form-control ' . ($errors->has('objetivo') ? ' is-invalid' : ''), 'rows' => 6, 'placeholder' => '']) }}
            {!! $errors->first('objetivo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-4">
            {{ Form::label('descripción') }}
            {{ Form::textarea('descripcion', $objetivo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'rows' => 6, 'placeholder' => '']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-5">
            {{ Form::label('indicadores') }}
            {{ Form::textarea('indicadores', $objetivo->indicadores, ['class' => 'form-control' . ($errors->has('indicadores') ? ' is-invalid' : ''), 'rows' => 6, 'placeholder' => '']) }}
            {!! $errors->first('indicadores', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="col-1">
            <div class="form-group">
                {{ Form::label('Porcentaje %') }}
                {{ Form::number('porcentaje', $objetivo->porcentaje, ['class' => 'form-control' . ($errors->has('porcentaje') ? ' is-invalid' : ''), 'placeholder' => '']) }}
                {!! $errors->first('porcentaje', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="form-group">
                {{ Form::label('Año') }}
                {{ Form::select('año_actividad', $years, date('Y'), ['class' => 'form-control' . ($errors->has('año_actividad') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona']) }}
                {!! $errors->first('año_actividad', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Entregar objetivo') }}</button>
    </div>
</div>
