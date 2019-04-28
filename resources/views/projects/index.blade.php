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
    <modal name="hello-world" classes="p-10 bg-card rounded-lg" height="auto">
        <h1 class="font-normal mb-16 text-center text-2xl">Create project</h1>
        <div class="flex">
            <div class="flex-1 mr-4">
                <div class="mb-4">
                    <label for="title" class="text-sm block mb-2">Title</label>
                    <input type="text" id="title" class="border border-muted-light p-2 text-xs block w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="description" class="text-sm block mb-2">Description</label>
                    <textarea type="description" id="title" class="border border-muted-light p-2 text-xs block w-full rounded" rows="7"></textarea>
                </div>
            </div>
            <div class="flex-1 ml-4">
                <div class="mb-4">
                    <label for="title" class="text-sm block mb-2">Need new?</label>
                    <input type="text" id="title" class="border border-muted-light p-2 text-xs block w-full rounded" placeholder="Task 1">
                </div>
                <button class="inline-flex items-center text-xs">
                    <span>Add New Task Field</span>
                </button>
            </div>
        </div>
        <footer class="flex justify-end">
            <button class="button mr-3 is-outlined">Cancel</button>
            <button class="button">Create Project</button>
        </footer>
    </modal>
    <a href="" @click.prevent="$modal.show('hello-world')">Show Modal</a>
@endsection

