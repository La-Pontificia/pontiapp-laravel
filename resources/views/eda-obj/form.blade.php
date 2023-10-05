<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_eda_colab') }}
            {{ Form::text('id_eda_colab', $edaObj->id_eda_colab, ['class' => 'form-control' . ($errors->has('id_eda_colab') ? ' is-invalid' : ''), 'placeholder' => 'Id Eda Colab']) }}
            {!! $errors->first('id_eda_colab', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_obj') }}
            {{ Form::text('id_obj', $edaObj->id_obj, ['class' => 'form-control' . ($errors->has('id_obj') ? ' is-invalid' : ''), 'placeholder' => 'Id Obj']) }}
            {!! $errors->first('id_obj', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>