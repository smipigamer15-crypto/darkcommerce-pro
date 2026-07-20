<div class="fixed bottom-6 right-6 z-50">
    <!-- Chat Button -->
    @if(!$isOpen)
        <button wire:click="open" 
                class="w-14 h-14 bg-indigo-500 hover:bg-indigo-400 rounded-2xl flex items-center justify-center shadow-2xl hover:shadow-indigo-500/25 transition-all hover:scale-110">
            <i class="fa-solid fa-comment-dots text-white text-xl"></i>
        </button>
    @endif

    <!-- Chat Window -->
    @if($isOpen)
        <div class="bg-[#111111] border border-white/10 rounded-2xl w-80 sm:w-96 shadow-2xl overflow-hidden animate-fade-in">
            <!-- Header -->
            <div class="bg-indigo-500 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-headset text-white"></i>
                        </div>
                        <div class="w-3 h-3 bg-green-400 rounded-full absolute -bottom-0.5 -right-0.5 border-2 border-indigo-500 animate-pulse"></div>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">Support Chat</p>
                        <p class="text-indigo-200 text-xs">We reply within 2 hours</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="close" class="text-white/70 hover:text-white transition-colors">
                        <i class="fa-solid fa-minus text-sm"></i>
                    </button>
                    <button wire:click="close" class="text-white/70 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <div class="h-80 overflow-y-auto p-4 space-y-3" id="chat-messages">
                @if(empty($messages))
                    <div class="text-center py-10">
                        <div class="w-12 h-12 mx-auto mb-3 bg-indigo-500/10 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-message text-indigo-400"></i>
                        </div>
                        <p class="text-white text-sm font-medium">Start a conversation</p>
                        <p class="text-zinc-500 text-xs mt-1">We're here to help!</p>
                    </div>
                @endif

                @foreach($messages as $msg)
                    <div class="flex {{ $msg['is_admin'] ? 'justify-start' : 'justify-end' }}">
                        <div class="max-w-[80%] {{ $msg['is_admin'] ? 'bg-white/5 rounded-tr-2xl' : 'bg-indigo-500 rounded-tl-2xl' }} rounded-2xl px-4 py-2.5">
                            <p class="text-xs {{ $msg['is_admin'] ? 'text-indigo-400' : 'text-indigo-200' }} font-medium">{{ $msg['user'] }}</p>
                            <p class="text-sm mt-1 {{ $msg['is_admin'] ? 'text-white' : 'text-white' }}">{{ $msg['message'] }}</p>
                            <p class="text-[10px] {{ $msg['is_admin'] ? 'text-zinc-500' : 'text-indigo-300' }} text-right mt-1">{{ $msg['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Input -->
            <div class="p-4 border-t border-white/5">
                <form wire:submit.prevent="sendMessage" class="flex gap-2">
                    <input type="text" wire:model="newMessage" placeholder="Type a message..." 
                           class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm placeholder-zinc-500 focus:outline-none focus:border-indigo-500/50 transition-all">
                    <button type="submit" class="px-4 py-2.5 bg-indigo-500 hover:bg-indigo-400 text-white rounded-xl transition-all hover:scale-105">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('scroll-chat', () => {
        const el = document.getElementById('chat-messages');
        if (el) {
            el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' });
        }
    });
</script>