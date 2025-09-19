<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class RunningText extends Component
{
    public $messages;

    public function mount() {
        $this->loadMessages();
    }

    public function loadMessages() {
        $this->messages = Message::whereDate('created_at', Carbon::today())
            ->latest()
            ->pluck('content')
            ->toArray();
    }

    protected $listeners = ['refreshRunningText' => 'loadMessages'];

    public function render()
    {
        return view('livewire.running-text');
    }
}
