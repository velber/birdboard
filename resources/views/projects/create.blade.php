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
        <form action="{{ route('projects.store') }}" method="post">
            @csrf
            <input type="text" name="title">
            <textarea name="description" id="" cols="30" rows="10"></textarea>
            <button>Create</button>
        </form>
    </ul>
</div>
</body>
</html>
