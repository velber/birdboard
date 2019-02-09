<div class="card" style="height: 200px;">
    <h1 class="font-normal text-xl py-4 pl-4 -ml-5 mb-3 border-blue-light border-l-4">
        <a href="{{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
    </h1>
    <div class="text-grey">{{ str_limit($project->description) }}</div>
</div>