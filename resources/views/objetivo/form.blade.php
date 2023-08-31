
<div class="box box-info padding-1">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <div class="box-body grid grid-cols-12 gap-3">
        
        {{-- <div class="form-group">
            {{ Form::label('colaborador') }}
            {{ Form::text('id_colaborador', $objetivo->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div> --}}
        <div class="form-group col-span-3" >
            {{ Form::label('objetivo') }}
            {{ Form::textarea('objetivo', $objetivo->objetivo, ['class' => 'form-control ' . ($errors->has('objetivo') ? ' is-invalid' : ''), 'rows' => 4, 'placeholder' => '']) }}
            {!! $errors->first('objetivo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-span-4">
            {{ Form::label('descripcion') }}
            {{ Form::textarea('descripcion', $objetivo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'rows' => 4, 'placeholder' => '']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Porcentaje %') }}
            {{ Form::number('porcentaje', $objetivo->porcentaje, ['class' => 'form-control' . ($errors->has('porcentaje') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('porcentaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-span-3">
            {{ Form::label('indicadores') }}
            {{ Form::textarea('indicadores', $objetivo->indicadores, ['class' => 'form-control' . ($errors->has('indicadores') ? ' is-invalid' : ''), 'rows' => 4, 'placeholder' => '']) }}
            {!! $errors->first('indicadores', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('f. venc') }}
            {{ Form::date('fecha_vencimiento', $objetivo->fecha_vencimiento, ['class' => 'form-control' . ($errors->has('fecha_vencimiento') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('fecha_vencimiento', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        {{-- <div class="form-group">
            {{ Form::label('año_actividad') }}
            {{ Form::text('año_actividad', $objetivo->año_actividad, ['class' => 'form-control' . ($errors->has('año_actividad') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('año_actividad', '<div class="invalid-feedback">:message</div>') !!}
        </div> --}}
    </div>
    <br>
    <div class="box-footer mt20"> 

        <button type="submit" class="btn btn-primary">{{ __('Entregar') }}</button>
    </div>
</div>
