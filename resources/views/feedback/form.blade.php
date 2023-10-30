<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_emisor') }}
            {{ Form::text('id_emisor', $feedback->id_emisor, ['class' => 'form-control' . ($errors->has('id_emisor') ? ' is-invalid' : ''), 'placeholder' => 'Id Emisor']) }}
            {!! $errors->first('id_emisor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_eda_colab') }}
            {{ Form::text('id_eda_colab', $feedback->id_eda_colab, ['class' => 'form-control' . ($errors->has('id_eda_colab') ? ' is-invalid' : ''), 'placeholder' => 'Id Eda Colab']) }}
            {!! $errors->first('id_eda_colab', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('feedback') }}
            {{ Form::text('feedback', $feedback->feedback, ['class' => 'form-control' . ($errors->has('feedback') ? ' is-invalid' : ''), 'placeholder' => 'Feedback']) }}
            {!! $errors->first('feedback', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('calificacion') }}
            {{ Form::text('calificacion', $feedback->calificacion, ['class' => 'form-control' . ($errors->has('calificacion') ? ' is-invalid' : ''), 'placeholder' => 'Calificacion']) }}
            {!! $errors->first('calificacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('recibido') }}
            {{ Form::text('recibido', $feedback->recibido, ['class' => 'form-control' . ($errors->has('recibido') ? ' is-invalid' : ''), 'placeholder' => 'Recibido']) }}
            {!! $errors->first('recibido', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_recibido') }}
            {{ Form::text('fecha_recibido', $feedback->fecha_recibido, ['class' => 'form-control' . ($errors->has('fecha_recibido') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Recibido']) }}
            {!! $errors->first('fecha_recibido', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>