<tbody class="divide-y">

    @foreach ($objetivos as $objetivo)
        <tr class="border-b border-gray-200 text-sm divide-x">
            @php
                $autocalificacion = $n_eva == 1 ? $objetivo->autocalificacion : $objetivo->autocalificacion_2;
                $promedio = $n_eva == 1 ? $objetivo->promedio : $objetivo->promedio_2;
            @endphp
            <th scope="row" class="px-6 py-4 text-sm font-semibold text-blue-900 bg-gray-50">
                <h3 class="">{{ $objetivo->objetivo }}</h3>
            </th>
            <td class="px-6 py-4">
                <div class=" text-sm overflow-ellipsis overflow-hidden">
                    {{ $objetivo->descripcion }}
                </div>
            </td>
            <td class="px-6 py-4 bg-gray-50">
                <div class=" text-sm overflow-ellipsis overflow-hidden">
                    {{ $objetivo->indicadores }}
                </div>
            </td>
            <td class="px-2 py-4">
                <div class="justify-center w-full flex">
                    <span
                        class="bg-purple-100 text-purple-800 p-1 px-3 text-sm font-medium mr-2 rounded-full">{{ $objetivo->porcentaje }}%</span>
                </div>
            </td>
            <td class="px-3 py-4 font-bold text-neutral-700 text-base">
                <div class="flex items-center justify-center gap-2">
                    {{ $autocalificacion }}
                </div>
            </td>
            <td class="px-3 py-4 font-bold text-neutral-700 text-base">
                <div class="flex items-center justify-center gap-2">
                    {{ $promedio }}
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
