@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="col-md-8 offset-md-4">
                    <a href="{{ route('projects.create') }}">
                        <button class="btn btn-primary" >
                            Create new Project
                        </button>
                    </a>
                </div><br>
                @foreach($projects as $project)
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('projects.show', compact('project')) }}">
                            {{ $project->name }} by {{ $project->creator_name }}
                        </a>
                    </div>

                </div><br><br>
                    @endforeach



            </div>
        </div>
    </div>
@endsection
