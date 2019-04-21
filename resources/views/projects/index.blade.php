@extends('layouts.app')

@section('content')
    <header class="flex items-end mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <h2 class="mb-3 mr-auto text-nowrap text-default text-sm">My Projects</h2>
            <a href="{{ route('projects.create') }}" class="button">Create a new project</a>
        </div>
    </header>
    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>No Projects yet.</div>
        @endforelse
    </main>
@endsection

