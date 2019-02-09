@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <h2 class="mb-3 mr-auto text-nowrap text-grey text-sm">My Projects</h2>
            <a href="{{ route('projects.create') }}" class="button">Create a new project</a>
        </div>
    </header>
    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-white p-5 rounded shadow" style="height: 200px;">
                    <h1 class="font-normal text-xl py-4 pl-4 -ml-5 mb-3 border-blue-light border-l-4">
                        <a href="{{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
                    </h1>
                    <div class="text-grey">{{ str_limit($project->description) }}</div>
                </div>
            </div>
        @empty
            <div>No Projects yet.</div>
        @endforelse
    </main>
@endsection

