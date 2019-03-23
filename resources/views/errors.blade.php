@if($errors->{ $bag ?? 'default' }->any())
    <ul class="field mt-6 text-small text-red list-reset">
        @foreach($errors->{ $bag ?? 'default' }->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif