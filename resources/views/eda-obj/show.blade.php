@extends('layouts.app')

@section('template_title')
    {{ $edaObj->name ?? "{{ __('Show') Eda Obj" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Eda Obj</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('eda-objs.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Eda Colab:</strong>
                            {{ $edaObj->id_eda_colab }}
                        </div>
                        <div class="form-group">
                            <strong>Id Obj:</strong>
                            {{ $edaObj->id_obj }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
