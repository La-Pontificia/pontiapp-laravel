    @forelse ($objetivos as $objetivo)
        @php
            $cerrado = $objetivo->edaColab->cerrado;
            $aprobado = $objetivo->edaColab->aprobado;
        @endphp
        <tr class="bg-white border-b :bg-gray-800 :border-gray-700">
            <th scope="row" class="px-6 py-3 font-medium text-gray-900 :text-white">
                <div class="line-clamp-2">
                    {{ $objetivo->objetivo }}
                </div>
            </th>
            {{-- <td class="px-6 py-3">
                <div class="line-clamp-2">
                    {{ $objetivo->descripcion }}
                </div>
            </td> --}}
            <td class="px-6 py-3">
                <a class="hover:underline"
                    href="/meta/{{ $objetivo->edaColab->id_colaborador }}/eda/{{ $objetivo->edaColab->id }}/objetivos?animate={{ $objetivo->id }}">
                    {{ $objetivo->promedio }}
                </a>
            </td>
            <td class="px-6 py-3">
                <a class="hover:underline"
                    href="/meta/{{ $objetivo->edaColab->id_colaborador }}/eda/{{ $objetivo->edaColab->id }}/objetivos?animate={{ $objetivo->id }}">
                    {{ $objetivo->promedio_2 }}
                </a>
            </td>
            <td class="px-6 py-3">
                <a class="hover:underline"
                    href="/meta/{{ $objetivo->edaColab->id_colaborador }}/eda/{{ $objetivo->edaColab->id }}/objetivos?animate={{ $objetivo->id }}">
                    {{ $objetivo->edaColab->eda->año }}
                </a>
            </td>
            <td class="px-6 py-3">
                <div
                    class="min-w-max font-semibold {{ $aprobado ? 'text-green-500' : 'text-neutral-500' }} {{ $cerrado ? 'text-red-500' : '' }}">
                    @if ($cerrado)
                        Cerrado
                    @elseif($aprobado)
                        Aprobado
                    @else
                        Sin aprobar
                    @endif
                </div>
            </td>
            <td class="px-6 py-3 text-right">
                {{-- <a href="#" class="font-medium text-blue-600 :text-blue-500 hover:underline">Edit</a> --}}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="10">
                <div class="p-10 grid place-content-center">
                    No hay colaboradores disponibles
                </div>
            </td>
        </tr>
    @endforelse
