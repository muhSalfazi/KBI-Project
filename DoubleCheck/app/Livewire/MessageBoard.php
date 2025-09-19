<?php

namespace App\Livewire;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MessageBoard extends Component
{
     public $content;

    protected $rules = [
        'content' => 'required|string|max:255',
    ];

    public function submit()
    {
        $this->validate();

        Message::create([
            'content' => $this->content,
            'sender' => Auth::user()->id_user,
        ]);

        $this->content = ''; // reset form

        session()->flash('success', 'Pesan berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.message-board', [
            'messages' => Message::with('senderName')->latest()->paginate(10), // ambil 10 pesan terbaru
        ]);
    }
}
