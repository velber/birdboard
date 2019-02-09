@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-3">
        <h1 class="mb-3 mr-auto">Projects</h1>
        <a href="{{ route('projects.create') }}">Create a new project</a>
    </div>
    <div class="flex">
        @forelse($projects as $project)
            <div class="bg-white mr-4 p-5 rounded shadow w-1/3" style="height: 200px;">
                <h1 class="font-normal text-xl my-4">{{ $project->title }}</h1>
                <div class="text-grey">{{ str_limit($project->description) }}</div>
            </div>
        @empty
            <div>No Projects yet.</div>
        @endforelse
    </div>
@endsection

