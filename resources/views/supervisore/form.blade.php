<div class=" padding-1">
    <div class=" grid gap-2 grid-cols-2">
        <div class="col-2">
            {{ Form::label('Colaborador') }}
            {{ Form::select('id_colaborador', $colabs, $supervisoreForm->id_colaborador, ['class' => 'block font-medium w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('id_colaborador') ? ' is-invalid' : '')]) }}
            {!! $errors->first('id_colaborador', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="col-2">
            {{ Form::label('Supervisor') }}
            {{ Form::select('id_supervisor', $colabs, $supervisoreForm->id_supervisor, ['class' => 'block font-medium w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . ($errors->has('id_supervisor') ? ' is-invalid' : '')]) }}
            {!! $errors->first('id_supervisor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <br>
    <div class="box-footer mt20">
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Guardar supervisor') }}</button>
    </div>
</div>
