<div class="card" style="height: 200px;">
    <h1 class="font-normal text-xl py-4 pl-4 -ml-5 mb-3 border-blue-light border-l-4">
        <a href="{{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
    </h1>
    <div class="text-grey mb-4">{{ str_limit($project->description) }}</div>

    <footer>
        <form action="{{ route('projects.destroy', ['project' => $project->id ]) }}" class="text-right" method="post">
            @csrf()
            @method('DELETE')
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
</div>