@extends('layouts.app')

@section('template_title')
    Objetivos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Mis objetivos') }}
                            </span>

                            {{-- <div class="float-right">
                                <a href="{{ route('objetivos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Create New') }}
                                </a>
                            </div> --}}
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th style="font-size: 15px; font-weight: 500; width: 50px;">No</th>
                                        <th style="font-size: 15px; font-weight: 500; ">Objetivo</th>
                                        <th style="font-size: 15px; font-weight: 500;">Descripción</th>
                                        <th style="font-size: 15px; font-weight: 500; width: 100px;">% Objetivo vs Total
                                        </th>
                                        <th style="font-size: 15px; font-weight: 500;">Indicador de Logros</th>
                                        <th style="font-size: 15px; font-weight: 500; width: 100px;">Fecha V.</th>
                                        <th style="font-size: 15px; font-weight: 500; width: 50px;">Pt. 01</th>
                                        {{-- <th>Fecha Calificacion 1</th>
                                        <th>Fecha Aprobacion 1</th> --}}
                                        <th style="font-size: 15px; font-weight: 500; width: 50px;">Pt. 02</th>
                                        {{-- <th>Fecha Calificacion 2</th>
                                        <th>Fecha Aprobacion 2</th> --}}
                                        {{-- <th>Ev 1</th>
                                        <th>Ev 2</th> --}}
                                        {{-- <th>Estado</th> --}}
                                        {{-- <th>Año Actividad</th> --}}
                                        {{-- <th style="width: 100px;"></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($objetivos as $objetivo)
                                        <tr>
                                            <td style="font-size: 14px;">{{ ++$i }}</td>
                                            <td style="font-size: 14px;">{{ $objetivo->objetivo }}</td>
                                            <td style="font-size: 14px;">{{ $objetivo->descripcion }}</td>
                                            <td style="font-size: 14px;">{{ $objetivo->porcentaje }}</td>
                                            <td style="font-size: 14px;">{{ $objetivo->indicadores }}</td>
                                            <td style="font-size: 14px;">
                                                {{ \Carbon\Carbon::parse($objetivo->fecha_vencimiento)->format('d/m/Y') }}
                                            </td>
                                            <td style="font-size: 14px;"
                                                title="{{ \Carbon\Carbon::parse($objetivo->fecha_calificacion_1)->format('d/m/Y') }}">
                                                {{ $objetivo->puntaje_01 }}</td>
                                            {{-- <td>{{ $objetivo->fecha_calificacion_1 }}</td> --}}
                                            {{-- <td>{{ $objetivo->fecha_aprobacion_1 }}</td> --}}
                                            <td>{{ $objetivo->puntaje_02 }}</td>
                                            {{-- <td>{{ $objetivo->fecha_calificacion_2 }}</td> --}}
                                            {{-- <td>{{ $objetivo->fecha_aprobacion_2 }}</td> --}}
                                            {{-- <td>
                                                @if ($objetivo->aprovado_ev_1 == 1)
                                                    <i style="font-size: 25px; color: green;"
                                                        class="fa-solid fa-circle-check"></i>
                                                @else
                                                    <i style="font-size: 25px ; color: red;"
                                                        class="fa-solid fa-circle-xmark"></i>
                                                @endif
                                            </td> --}}
                                            {{-- <td>
                                                @if ($objetivo->aprovado_ev_2 == 1)
                                                    <i style="font-size: 25px; color: green;"
                                                        class="fa-solid fa-circle-check"></i>
                                                @else
                                                    <i style="font-size: 25px ; color: red;"
                                                        class="fa-solid fa-circle-xmark"></i>
                                                @endif
                                            </td> --}}
                                            {{-- <td>
                                                @if ($objetivo->aprobado == 1)
                                                    <i style="font-size: 25px; color: green;"
                                                        class="fa-solid fa-circle-check"></i>
                                                @else
                                                    <i style="font-size: 25px ; color: red;"
                                                        class="fa-solid fa-circle-xmark"></i>
                                                @endif
                                            </td> --}}
                                            {{-- <td>{{ $objetivo->año_actividad }}</td> --}}


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                @includeif('partials.errors')

                {{-- @if ($mostrarFormulario) --}}
                <div class="card card-default">
                    <div class="card-body">
                        <form method="POST" action="{{ route('objetivos.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            @include('objetivo.form', ['objetivo' => $objetivoForm])
                        </form>
                    </div>
                </div>
                {{-- @else --}}
                {{-- <div class="alert alert-warning">
                    Tu último objetivo entregado no ha sido aprobado.
                </div> --}}
                {{-- @endif --}}
            </div>
        </div>
    </div>
@endsection
