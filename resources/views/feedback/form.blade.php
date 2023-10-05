<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_transmitter') }}
            {{ Form::text('id_transmitter', $feedback->id_transmitter, ['class' => 'form-control' . ($errors->has('id_transmitter') ? ' is-invalid' : ''), 'placeholder' => 'Id Transmitter']) }}
            {!! $errors->first('id_transmitter', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_receiver') }}
            {{ Form::text('id_receiver', $feedback->id_receiver, ['class' => 'form-control' . ($errors->has('id_receiver') ? ' is-invalid' : ''), 'placeholder' => 'Id Receiver']) }}
            {!! $errors->first('id_receiver', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('feedback') }}
            {{ Form::text('feedback', $feedback->feedback, ['class' => 'form-control' . ($errors->has('feedback') ? ' is-invalid' : ''), 'placeholder' => 'Feedback']) }}
            {!! $errors->first('feedback', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status') }}
            {{ Form::text('status', $feedback->status, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>