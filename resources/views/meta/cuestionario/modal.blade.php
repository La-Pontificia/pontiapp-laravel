 <!-- CREATE -->
 <div id="cuestionario-modal" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <div class="relative max-w-xl w-full max-h-full">
         <!-- Modal content -->
         <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700">
             <button type="button"
                 class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                 data-modal-hide="cuestionario-modal">
                 <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                 </svg>
             </button>
             <div class="px-4 py-4">
                 <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                     Completa el cuestionario</h3>
                 <div id="list-question" class="flex flex-col divide-y ">
                     @foreach ($plantilla->plantillaPreguntas as $item)
                         <label for="{{ $item->pregunta->id }}">
                             <p class="p-1 font-medium">{{ $item->pregunta->pregunta }}</p>
                             <textarea data-id="{{ $item->pregunta->id }}" rows="4"
                                 class="outline-none question-input border-transparent px-4 w-full text-left py-2 hover:bg-gray-300 bg-gray-200 rounded-xl"
                                 placeholder="Ingrese tu respuesta" type="text"></textarea>
                         </label>
                     @endforEach
                 </div>
                 <footer>
                     <button id="submit-btn" type="button" data-id="{{ $edaSeleccionado->id }}"
                         data-de="{{ $miPerfil ? '1' : '2' }}"
                         class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center gap-2">
                         <svg class="w-6 h-6 rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 18 20">
                             <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9" />
                         </svg>
                         Enviar cuestionario
                     </button>
                 </footer>
                 {{-- <form method="POST" id="form-store-obj" class=""
                     action="/meta/{{ $id_colab }}/eda/{{ $id_eda }}/objetivos" role="form"
                     style="margin: 0" class="mb-0" enctype="multipart/form-data">
                     @csrf
                     @include('meta.objetivos.form', [
                         'objetivo' => $objetivoNewForm,
                     ])
                     <footer class="flex justify-end gap-2 mt-2 items-center">
                         <input type="number" required name="porcentaje" value="{{ $objetivoNewForm->porcentaje }}"
                             placeholder="Porcentaje %"
                             class="w-[150px] border rounded-xl focus:outline-2 transition-all focus:outline-blue-600">
                         <button data-modal-target="create-colab-modal" type="button" type="button"
                             data-modal-toggle="create-colab-modal"
                             class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-sm px-5 py-2.5">Cerrar</button>
                         <button
                             class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-10 py-2.5 text-center"
                             type="submit">
                             Entregar objetivo
                         </button>
                     </footer>
                 </form> --}}
             </div>
         </div>
     </div>
 </div>


 @section('script')
     <script>
         var respuestas = [];
         document.getElementById('submit-btn').addEventListener('click', function() {
             var textareas = document.querySelectorAll('#list-question textarea');
             var todasRespuestasLlenas = true;
             const id_eda = this.dataset.id;
             const de = this.dataset.de;

             respuestas = [];
             textareas.forEach(function(textarea) {
                 if (textarea.value.trim() === '') {
                     todasRespuestasLlenas = false;
                     return;
                 }
                 respuestas.push({
                     id_pregunta: textarea.dataset.id,
                     respuesta: textarea.value.trim()
                 });
             });

             if (todasRespuestasLlenas) {
                 axios.post(`/cuestionario/eda/${id_eda}`, {
                     respuestas,
                     de
                 }).then(res => {
                     console.log(res.data)
                 }).catch((err) => {
                     console.log(err)
                 })
             } else {
                 Swal.fire({
                     icon: 'info',
                     title: 'Incompleto',
                     text: 'Por favor responde todas las preguntas',
                 }).then(() => {
                     todasRespuestasLlenas = false
                 })
             }
         });
     </script>
 @endsection
