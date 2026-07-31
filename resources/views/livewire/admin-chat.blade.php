<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">Chat Messages</h1>
        <button wire:click="clearChat" class="px-4 py-2 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-sm hover:bg-red-500/20 transition-all">
            <i class="fa-solid fa-trash mr-1"></i> Clear Chat
        </button>
    </div>

    <div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden">
        <div class="h-[500px] overflow-y-auto p-6 space-y-4" id="admin-chat-messages">
            @forelse($messages as $msg)
                <div class="flex {{ $msg['is_admin'] ? 'justify-start' : 'justify-end' }}">
                    <div class="max-w-[60%] {{ $msg['is_admin'] ? 'bg-indigo-500/10 border border-indigo-500/20' : 'bg-white/5 border border-white/10' }} rounded-2xl px-4 py-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium {{ $msg['is_admin'] ? 'text-indigo-400' : 'text-zinc-400' }}">{{ $msg['user'] }}</span>
                            <span class="text-[10px] text-zinc-500">{{ $msg['time'] }}</span>
                        </div>
                        <p class="text-sm text-white">{{ $msg['message'] }}</p>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <div class="w-16 h-16 mb-4 bg-white/5 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-message text-2xl text-zinc-600"></i>
                    </div>
                    <p class="text-zinc-400">No messages yet</p>
                    <p class="text-zinc-500 text-sm mt-1">Customer messages will appear here</p>
                </div>
            @endforelse
        </div>


        <div class="border-t border-white/5 p-4">
            <form wire:submit.prevent="sendReply" class="flex gap-3">
                <input type="text" wire:model="replyMessage" placeholder="Type your reply..." 
                       class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 transition-all">
                <button type="submit" class="px-6 py-3 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold rounded-xl transition-all hover:scale-105">
                    <i class="fa-solid fa-paper-plane mr-1"></i> Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('admin-chat-messages');
    if (container) {
        container.scrollTop = container.scrollHeight;
        const observer = new MutationObserver(() => { container.scrollTop = container.scrollHeight; });
        observer.observe(container, { childList: true });
    }
</script>

