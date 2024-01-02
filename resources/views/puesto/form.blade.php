<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$puesto->codigo_puesto}}" name="codigo_puesto" type="text">
            
            {{-- {{ Form::label('Codigo') }}
            {{ Form::text('codigo_puesto', $puesto->codigo_puesto, ['class' => 'form-control' . ($errors->has('codigo_puesto') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('codigo_puesto', '<div class="invalid-feedback">:message</div>') !!} --}}
        </div>

        <div>
            <label for="puesto"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Puesto</label>
            <input value="{{$puesto->nombre_puesto}}" name="nombre_puesto" type="text" id="puesto"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="" required>
        </div>
        
<br>
        <div class="form-group">
            <label for="departamento"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
            <select name="id_departamento"
            class="rounded-lg border-b even:bg-gray-100 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
            
            <option selected value="">Departamento</option>
            
            @foreach ($depas as $departamento)
                <option {{ $puesto->id_departamento == $departamento->id ? 'selected' : '' }} value="{{ $departamento->id }}">
                    {{ $departamento->nombre_departamento }}
                </option>
            @endforeach
        </select>
          
        </div>

    </div>
    <br>    
    
    <div class="box-footer mt20">
        <button  class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Actualizar</button>
        
    </div>
</div>
