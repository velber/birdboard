@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Projects</h1>
        <ul>
            <form action="{{ route('projects.store') }}" method="post">
                @csrf
                <input type="text" name="title">
                <textarea name="description" id="" cols="30" rows="10"></textarea>
                <button>Create</button>
                <a href="{{ route('projects.index') }}">Cancel</a>
            </form>
        </ul>
    </div>
@endsection
