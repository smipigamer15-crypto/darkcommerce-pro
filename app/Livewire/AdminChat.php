<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class AdminChat extends Component
{
    public $messages = [];
    public $replyMessage = '';

    public function mount()
    {
        $this->messages = Cache::get('chat_messages', []);
    }

    public function sendReply()
    {
        if (trim($this->replyMessage) === '') return;

        $messages = Cache::get('chat_messages', []);
        $messages[] = [
            'user' => 'Support Team',
            'message' => $this->replyMessage,
            'time' => now()->format('H:i'),
            'is_admin' => true,
        ];
        Cache::put('chat_messages', $messages, now()->addDay());

        $this->replyMessage = '';
        $this->messages = $messages;
    }

    public function clearChat()
    {
        Cache::forget('chat_messages');
        $this->messages = [];
    }

    public function render()
    {
        return view('livewire.admin-chat');
    }
}