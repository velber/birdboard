<div class="card mt-3" style="height: 200px;">
    <ul class="text-xs list-reset">
        @foreach($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }}">
                You {{ $activity->description }} {{ $activity->subject ? '"' . $activity->subject->body . '"': '' }}
                <span class="text-grey">{{ $activity->created_at->diffForHumans(null, true) }}</span> </li>
        @endforeach
    </ul>
</div>