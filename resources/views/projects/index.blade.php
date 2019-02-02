<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Projects</title>
</head>
<body>
<div class="flex-center position-ref full-height">

    <h1>Projects</h1>
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
</body>
</html>
