 <!-- CREATE -->
 <div id="cuestionario-modal-preview" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
     <div class="relative max-w-xl w-full max-h-full">
         <!-- Modal content -->
         <div class="relative bg-gradient-to-t from-violet-100 to-blue-100 rounded-2xl shadow ">
             <button type="button"
                 class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                 data-modal-hide="cuestionario-modal-preview">
                 <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                 </svg>
             </button>
             <div class="px-4 py-4">
                 <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                     Cuestionario del {{ $miPerfil ? 'supervisor' : 'colaborador' }}
                 </h3>
                 <div id="list-question" class="flex flex-col gap-3">
                     @foreach ($cuestionario->cuestionarioPreguntas as $index => $item)
                         <div>
                             <h1 class="p-1 font-medium">
                                 <span>{{ $index + 1 }}</span>. {{ $item->pregunta->pregunta }}
                             </h1>
                             <p class="p-2 rounded-xl opacity-80 text-lg">{{ $item->respuesta }}</p>
                         </div>
                     @endforEach
                 </div>
             </div>
         </div>
     </div>
 </div>
