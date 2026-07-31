<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ChatSupport extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isOpen = false;

    public function mount()
    {
        $this->messages = Cache::get('chat_messages', []);
    }

    public function open()
    {
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function sendMessage()
    {
        if (trim($this->newMessage) === '') return;

        $messages = Cache::get('chat_messages', []);
        $messages[] = [
            'user' => auth()->user()->name ?? 'Guest',
            'message' => $this->newMessage,
            'time' => now()->format('H:i'),
            'is_admin' => false,
        ];
        Cache::put('chat_messages', $messages, now()->addDay());

        $responses = [
            "Hi! Thanks for your message. Our team will reply within 2 hours.",
            "Thanks for reaching out! How can we help you today?",
            "We've received your message. We'll get back to you soon!",
        ];

        $messages[] = [
            'user' => 'Support Bot',
            'message' => $responses[array_rand($responses)],
            'time' => now()->format('H:i'),
            'is_admin' => true,
        ];
        Cache::put('chat_messages', $messages, now()->addDay());

        $this->messages = $messages;
        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.chat-support');
    }
}