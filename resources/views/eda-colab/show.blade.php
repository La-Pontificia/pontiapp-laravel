@extends('layouts.app')

@section('template_title')
    {{ $edaColab->name ?? "{{ __('Show') Eda Colab" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Eda Colab</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('eda-colabs.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Eda:</strong>
                            {{ $edaColab->id_eda }}
                        </div>
                        <div class="form-group">
                            <strong>Id Colaborador:</strong>
                            {{ $edaColab->id_colaborador }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $edaColab->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Cant Obj:</strong>
                            {{ $edaColab->cant_obj }}
                        </div>
                        <div class="form-group">
                            <strong>Nota Final:</strong>
                            {{ $edaColab->nota_final }}
                        </div>
                        <div class="form-group">
                            <strong>Wearing:</strong>
                            {{ $edaColab->wearing }}
                        </div>
                        <div class="form-group">
                            <strong>F Envio:</strong>
                            {{ $edaColab->f_envio }}
                        </div>
                        <div class="form-group">
                            <strong>F Aprobacion:</strong>
                            {{ $edaColab->f_aprobacion }}
                        </div>
                        <div class="form-group">
                            <strong>F Cerrado:</strong>
                            {{ $edaColab->f_cerrado }}
                        </div>
                        <div class="form-group">
                            <strong>Flimit Send Obj From:</strong>
                            {{ $edaColab->flimit_send_obj_from }}
                        </div>
                        <div class="form-group">
                            <strong>Flimit Send Obj At:</strong>
                            {{ $edaColab->flimit_send_obj_at }}
                        </div>
                        <div class="form-group">
                            <strong>Flimit White Autoeva From:</strong>
                            {{ $edaColab->flimit_white_autoeva_from }}
                        </div>
                        <div class="form-group">
                            <strong>Flimit White Autoeva At:</strong>
                            {{ $edaColab->flimit_white_autoeva_at }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
