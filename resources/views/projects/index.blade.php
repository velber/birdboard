@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex items-center">
            <h1 class="mb-3 mr-auto">Projects</h1>
            <a href="{{ route('projects.create') }}">Create a new project</a>
        </div>
        <ul>
            @forelse($projects as $project)
                <li>
                    <a href="{{ $project->path() }}">
                        {{ $project->title }}
                    </a>
                </li>
            @empty
                <p>No Projects yet.</p>
            @endforelse
        </ul>
    </div>
@endsection

