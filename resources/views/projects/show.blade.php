@extends('layouts.app')

@section('content')
    <header class="flex items-end mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <p class="text-default text-sm font-normal">
                <a href="{{ route('projects.index') }}" class="text-default text-sm font-normal no-underline">My Projects</a> / {{ $project->title }}
            </p>
            <div class="flex items-center">
                @foreach($project->members as $member)
                    <img class="rounded-full w-8 mr-2"
                         src="{{ gravatar_url($project->owner->email) }}"
                         alt="{{ $member->name }}'s avatar">
                @endforeach
                    <img class="rounded-full w-8 mr-2"
                         src="{{ gravatar_url($project->owner->email) }}"
                         alt="{{ $project->owner->name }}'s avatar" >
                    <a href="{{ route('projects.edit', ['project' => $project->id ]) }}" class="button ml-4">Edit project</a>
            </div>
        </div>
    </header>
    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-default text-lg font-normal mb-3">Tasks</h2>
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input type="text" name="body" value="{{ $task->body }}" class="bg-card text-default w-full {{  $task->completed ? 'text-default' : '' }}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf
                            <input name="body" type="text" class="bg-card text-default w-full" placeholder="Add a new task...">
                        </form>
                    </div>
                </div>
                <div class="mb-8">
                    <h2 class="text-default text-lg font-normal mb-3">General Notes</h2>

                    {{-- General Notes--}}
                    <form action="{{ $project->path() }}" method="post">
                        @csrf
                        @method('patch')
                        <textarea class="card w-full mb-4" style="min-height: 200px;"
                                  placeholder="Note..."
                                  name="notes"
                        >{{ $project->notes }}</textarea>
                        <button type="submit" class="button">Update</button>
                    </form>
                    @include('errors')
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
                @include('projects.activity')
                @can('manage', $project)
                    @include('projects.invite')
                @endif
            </div>
        </div>
    </main>
@endsection