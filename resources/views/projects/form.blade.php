<div class="field mb-6">
    <label for="title">Title</label>
    <div class="control">
        <input id="title"
               type="text"
               name="title"
               value="{{ $project->title }}"
               class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
               required>
    </div>
</div>
<div class="field mb-6">
    <label for="title" for="description">Description</label>
    <div class="control">
                        <textarea
                                class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                                name="description"
                                id="description"
                                cols="30"
                                rows="10"
                                required
                        >{{ $project->description }}</textarea>
    </div>
</div>
<button class="button">{{ $buttonText }}</button>
<a href="{{ $project->path() }}">Cancel</a>

@if($errors->any())
    <div class="field mt-6 text-small text-red">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif