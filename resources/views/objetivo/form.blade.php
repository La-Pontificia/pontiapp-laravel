{{-- <div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('id_colaborador') }}
            {{ Form::text('id_colaborador', $objetivo->id_colaborador, ['class' => 'form-control' . ($errors->has('id_colaborador') ? ' is-invalid' : ''), 'placeholder' => 'Id Colaborador']) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_supervisor') }}
            {{ Form::text('id_supervisor', $objetivo->id_supervisor, ['class' => 'form-control' . ($errors->has('id_supervisor') ? ' is-invalid' : ''), 'placeholder' => 'Id Supervisor']) }}
            {!! $errors->first('id_supervisor', '<div class="invalid-feedback">:message</div>') !!}
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
            {{ Form::label('indicadores') }}
            {{ Form::text('indicadores', $objetivo->indicadores, ['class' => 'form-control' . ($errors->has('indicadores') ? ' is-invalid' : ''), 'placeholder' => 'Indicadores']) }}
            {!! $errors->first('indicadores', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('porcentaje') }}
            {{ Form::text('porcentaje', $objetivo->porcentaje, ['class' => 'form-control' . ($errors->has('porcentaje') ? ' is-invalid' : ''), 'placeholder' => 'Porcentaje']) }}
            {!! $errors->first('porcentaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $objetivo->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado_fecha') }}
            {{ Form::text('estado_fecha', $objetivo->estado_fecha, ['class' => 'form-control' . ($errors->has('estado_fecha') ? ' is-invalid' : ''), 'placeholder' => 'Estado Fecha']) }}
            {!! $errors->first('estado_fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('feedback') }}
            {{ Form::text('feedback', $objetivo->feedback, ['class' => 'form-control' . ($errors->has('feedback') ? ' is-invalid' : ''), 'placeholder' => 'Feedback']) }}
            {!! $errors->first('feedback', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('feedback_fecha') }}
            {{ Form::text('feedback_fecha', $objetivo->feedback_fecha, ['class' => 'form-control' . ($errors->has('feedback_fecha') ? ' is-invalid' : ''), 'placeholder' => 'Feedback Fecha']) }}
            {!! $errors->first('feedback_fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nota_colab') }}
            {{ Form::text('nota_colab', $objetivo->nota_colab, ['class' => 'form-control' . ($errors->has('nota_colab') ? ' is-invalid' : ''), 'placeholder' => 'Nota Colab']) }}
            {!! $errors->first('nota_colab', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nota_super') }}
            {{ Form::text('nota_super', $objetivo->nota_super, ['class' => 'form-control' . ($errors->has('nota_super') ? ' is-invalid' : ''), 'placeholder' => 'Nota Super']) }}
            {!! $errors->first('nota_super', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nota_super_fecha') }}
            {{ Form::text('nota_super_fecha', $objetivo->nota_super_fecha, ['class' => 'form-control' . ($errors->has('nota_super_fecha') ? ' is-invalid' : ''), 'placeholder' => 'Nota Super Fecha']) }}
            {!! $errors->first('nota_super_fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('eva') }}
            {{ Form::text('eva', $objetivo->eva, ['class' => 'form-control' . ($errors->has('eva') ? ' is-invalid' : ''), 'placeholder' => 'Eva']) }}
            {!! $errors->first('eva', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('año') }}
            {{ Form::text('año', $objetivo->año, ['class' => 'form-control' . ($errors->has('año') ? ' is-invalid' : ''), 'placeholder' => 'Año']) }}
            {!! $errors->first('año', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('notify_super') }}
            {{ Form::text('notify_super', $objetivo->notify_super, ['class' => 'form-control' . ($errors->has('notify_super') ? ' is-invalid' : ''), 'placeholder' => 'Notify Super']) }}
            {!! $errors->first('notify_super', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('notify_colab') }}
            {{ Form::text('notify_colab', $objetivo->notify_colab, ['class' => 'form-control' . ($errors->has('notify_colab') ? ' is-invalid' : ''), 'placeholder' => 'Notify Colab']) }}
            {!! $errors->first('notify_colab', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div> --}}


<div class="grid grid-cols-4 gap-2 text-left">
    <div class="mb-1 col-span-4">
        <label for="objetivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Objetivo</label>
        {{ Form::text('objetivo', $objetivo->objetivo, ['id' => 'objetivo', 'required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('objetivo') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'placeholder' => 'Ingresa el titulo/nombre del objetivo']) }}
        {!! $errors->first('objetivo', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
    </div>
    <div class="col-span-4 grid grid-cols-1 gap-2">
        <div class="mb-1 col-span-1">
            <label for="descripción" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Objetivo</label>
            {{ Form::textarea('descripcion', $objetivo->descripcion, ['rows' => '10', 'id' => 'descripcion', 'required' => 'required', 'rows' => '3', 'class' => 'block p-2.5 w-full min-h-[100px] text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('descripcion') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'placeholder' => 'Ingresa la descripción del objetivo']) }}
            {!! $errors->first('descripcion', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
        </div>
        <div class="mb-1 col-span-1">
            <label for="indicadores"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Indicadores</label>
            {{ Form::textarea('indicadores', $objetivo->indicadores, ['rows' => '10', 'id' => 'indicadores', 'required' => 'required', 'class' => 'block p-2.5 w-full min-h-[100px] text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('indicadores') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'placeholder' => 'Ingresa los indicadores del objetivo']) }}
            {!! $errors->first('indicadores', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
        </div>
    </div>
    <div class="col-span-4 grid grid-cols-2 gap-2">
        <div class="">
            <label for="porcentaje"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Porcentaje</label>
            {{ Form::number('porcentaje', $objetivo->porcentaje, ['rows' => '10', 'id' => 'porcentaje', 'required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('porcentaje') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'placeholder' => '% del objetivo']) }}
            {!! $errors->first('porcentaje', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
        </div>
        <div class="">
            <label for="autoevaluacion"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Autoevaluación</label>
            {{ Form::select('nota_colab', [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], $objetivo->nota_colab, ['id' => 'autoevaluacion', 'required' => 'required', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('nota_colab') ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' : ''), 'placeholder' => 'Ingresa tu puntaje inicial']) }}
            {!! $errors->first('nota_colab', '<p class="mt-2 text-sm text-red-600 dark:text-red-500">:message</p>') !!}
        </div>
    </div>
</div>
