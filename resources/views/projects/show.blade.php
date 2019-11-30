@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Project</div>

                    <div class="card-body">

                        <label class="col-md-6 col-form-label text-md-right">Name: {{ $project->name }}</label>
                        <label class="col-md-6 col-form-label text-md-right">Creator: {{ $project->creator_name }}</label>
                        @if(Auth::id() == $project->creator_id)
                            <p class="col-md-14 col-form-label text-md-right">Token: {{ $project->token }}</p>
                            <form method="post" action="{{ route('projects.destroy', compact('project')) }}">
                                @method('delete')
                                @csrf



                                {{-- добавить вывод подписчиков проекта --}}
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Delete project
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @if(!empty($subscriptions))
                                <hr>
                                <h4>Subs:</h4>
                                @foreach($subscriptions as $sub)
                                    <p class="col-md-8 col-form-label text-md-right">Name: {{ $sub->sub_name }}, Date: {{ $sub->updated_at }}</p>
                                @endforeach
                            @endif
                            @else
                            <form method="post" action="{{ route('subscriptions.store', compact('project')) }}">

                                @csrf
                                {{-- добавить вывод подписчиков проекта --}}
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Subscribe
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
