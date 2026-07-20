@extends('layouts.admin')

@section('title', 'Returns - Admin')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-8">Return Requests</h1>

    <div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-zinc-400 text-sm border-b border-white/5">
                    <th class="p-4">RMA #</th>
                    <th class="p-4">Order</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Reason</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($returns as $return)
                    <tr class="hover:bg-white/5">
                        <td class="p-4 text-white font-mono">{{ $return->rma_number }}</td>
                        <td class="p-4 text-white">#{{ $return->order->order_number }}</td>
                        <td class="p-4 text-white">{{ $return->user->name }}</td>
                        <td class="p-4 text-zinc-400 max-w-xs truncate">{{ $return->reason }}</td>
                        <td class="p-4">
                            <form action="{{ route('admin.returns.update', $return) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-xs rounded-full px-3 py-1.5 bg-white/5 border border-white/10 text-white">
                                    <option value="pending" {{ $return->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $return->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $return->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="completed" {{ $return->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4">
                            <a href="{{ route('returns.show', $return) }}" class="text-indigo-400 text-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $returns->links() }}</div>
</div>
@endsection