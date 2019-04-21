<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 pl-4 -ml-5 mb-3 border-blue-light border-l-4">
        <a href="{{ $project->path() }}" class="text-default no-underline">Invite a user</a>
    </h3>
    <form action="{{ route('projects.invitations', ['project' => $project->id ]) }}" method="post">
        @csrf()
        <div class="mb-3">
            <input type="email" name="email" class="border border-grey rounded w-full py-2 px-3" placeholder="Email address">
        </div>
        <button type="submit" class="button">Invite</button>

        @include('errors', ['bag' => 'invitations'])
    </form>
</div>
