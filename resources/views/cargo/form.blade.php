<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            <label for="cargo"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo</label>
            <input
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                value="{{ $cargo->codigo_cargo }}" name="codigo_cargo" type="text">

        
        <div class="form-group">
            <label for="cargo"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Puesto</label>
            <input
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                value="{{ $cargo->nombre_cargo }}" name="nombre_cargo" type="text">
          

        </div>
        <br>
        <div class="box-footer ">
            <button  class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Actualizar</button>
        </div>
    </div>
