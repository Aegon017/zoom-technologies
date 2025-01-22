<div>
    @foreach ($getState() as $key => $state)
        {{ $state }}{{ !$loop->last ? ',' : '' }}
    @endforeach
</div>
