@php
    use App\Models\Acceso;
    use App\Models\Colaboradore;
    $user = auth()->user();
    if ($user) {
        $id = $user->id;
        $colab = Colaboradore::where([
            'id_usuario' => $id,
        ])->first();

        if ($colab) {
            $a_colaboradores = Acceso::where('id_colaborador', $colab->id)
                ->where('modulo', 'colaboradores')
                ->get();
            $a_accesos = Acceso::where('id_colaborador', $colab->id)
                ->where('modulo', 'acessos')
                ->get();
            $a_edas = Acceso::where('id_colaborador', $colab->id)
                ->where('modulo', 'edas')
                ->get();
            $a_departamentos = Acceso::where('id_colaborador', $colab->id)
                ->where('modulo', 'departamentos')
                ->get();
            $a_cargos = Acceso::where('id_colaborador', $colab->id)
                ->where('modulo', 'cargos')
                ->get();
            $a_puestos = Acceso::where('id_colaborador', $colab->id)
                ->where('modulo', 'puestos')
                ->get();
            $a_sedes = Acceso::where('id_colaborador', $colab->id)
                ->where('modulo', 'sedes')
                ->get();
        }
    }
@endphp
