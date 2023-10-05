@extends('layouts.app')

@section('template_title')
    {{ $feedback->name ?? "{{ __('Show') Feedback" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Feedback</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('feedback.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Transmitter:</strong>
                            {{ $feedback->id_transmitter }}
                        </div>
                        <div class="form-group">
                            <strong>Id Receiver:</strong>
                            {{ $feedback->id_receiver }}
                        </div>
                        <div class="form-group">
                            <strong>Feedback:</strong>
                            {{ $feedback->feedback }}
                        </div>
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $feedback->status }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
