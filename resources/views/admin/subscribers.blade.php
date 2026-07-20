@extends('layouts.admin')

@section('title', 'Subscribers - Admin')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">Newsletter Subscribers</h1>
    </div>

    <div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-zinc-400 text-sm border-b border-white/5">
                    <th class="p-4">Email</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Subscribed</th>
                    <th class="p-4">Unsubscribed</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($subscribers as $subscriber)
                    <tr class="hover:bg-white/5">
                        <td class="p-4 text-white">{{ $subscriber->email }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $subscriber->is_active ? 'bg-green-500/10 text-green-400' : 'bg-zinc-500/10 text-zinc-400' }}">
                                {{ $subscriber->is_active ? 'Active' : 'Unsubscribed' }}
                            </span>
                        </td>
                        <td class="p-4 text-zinc-400 text-sm">{{ $subscriber->subscribed_at?->format('M d, Y') ?? '-' }}</td>
                        <td class="p-4 text-zinc-400 text-sm">{{ $subscriber->unsubscribed_at?->format('M d, Y') ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">{{ $subscribers->links() }}</div>
</div>
@endsection