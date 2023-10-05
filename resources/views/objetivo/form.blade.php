<div class="box box-info padding-1">
    <span>
        <input required name="objetivo" type="text" value="{{ $objetivo->objetivo }}" placeholder="Objetivo"
            class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600">
    </span>

    <span>
        <textarea required name="descripcion" type="text" value="{{ $objetivo->descripcion }}" placeholder="Objetivo"
            class="rounded-xl w-full text-lg font-medium border-neutral-300 outline-none focus:outline-2 transition-all focus:outline-blue-600"></textarea>
    </span>

    <div class="box-body">

        {{-- <div class="form-group">
            {{ Form::label('objetivo') }}
            {{ Form::text('objetivo', , ['class' => 'form-control' . ($errors->has('objetivo') ? ' is-invalid' : ''), 'placeholder' => 'Objetivo']) }}
            {!! $errors->first('objetivo', '<div class="invalid-feedback">:message</div>') !!}
        </div> --}}

        {{-- <div class="form-group">
            {{ Form::label('descripcion') }}
            {{ Form::text('descripcion', $objetivo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div> --}}
        <div class="form-group">
            {{ Form::label('indicadores') }}
            {{ Form::text('indicadores', $objetivo->indicadores, ['class' => 'form-control' . ($errors->has('indicadores') ? ' is-invalid' : ''), 'placeholder' => 'Indicadores']) }}
            {!! $errors->first('indicadores', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('porcentaje') }}
            {{ Form::text('porcentaje', $objetivo->porcentaje, ['class' => 'form-control' . ($errors->has('porcentaje') ? ' is-invalid' : ''), 'placeholder' => 'Porcentaje']) }}
            {!! $errors->first('porcentaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
