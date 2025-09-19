<div>
    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form Input -->
    <form wire:submit.prevent="submit" class="mb-3">
        <div class="input-group">
            <input type="text" wire:model="content" class="form-control" placeholder="Tulis pesan singkat...">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
        @error('content')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </form>

    <!-- List Pesan -->
    <ul class="list-group">
        @foreach($messages as $msg)
            <li class="list-group-item">
                <div class="row align-items-start">
                    <!-- Content -->
                    <div class="col-7 text-wrap">
                        {{ $msg->content }}
                    </div>

                    <!-- Created At -->
                    <div class="col-3 text-muted text-end">
                        {{ $msg->created_at->diffForHumans() }}
                    </div>

                    <!-- Sender -->
                    <div class="col-2 text-end">
                        <b>{{ $msg->senderName->full_name }}</b>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
