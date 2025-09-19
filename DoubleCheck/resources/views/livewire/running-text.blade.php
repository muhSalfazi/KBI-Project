<div wire:poll.10s>
    <div class="running-text">
        <div class="overflow-hidden position-relative" style="height: 25px;">
            <div class="d-inline-block text-nowrap ticker-text">
                @foreach($messages as $msg)
                    <span class="mx-5">{{ $msg }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
