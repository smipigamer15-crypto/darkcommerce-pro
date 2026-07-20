@extends('layouts.admin')

@section('title', 'Users - Admin')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">Users</h1>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-zinc-400 text-sm border-b border-white/5">
                    <th class="p-4">User</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Orders</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Joined</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($users as $user)
                    <tr class="hover:bg-white/5">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-indigo-500/20 rounded-full flex items-center justify-center text-indigo-400 font-bold text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="text-white font-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-zinc-400">{{ $user->email }}</td>
                        <td class="p-4 text-white">{{ $user->orders_count }}</td>
                        <td class="p-4">
                            <form action="{{ route('admin.users.role', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="is_admin" onchange="this.form.submit()" 
                                        class="text-xs font-medium rounded-full px-3 py-1.5 cursor-pointer {{ $user->is_admin ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'bg-zinc-500/10 text-zinc-400 border border-zinc-500/20' }}">
                                    <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>Customer</option>
                                    <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4 text-zinc-400 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="p-4">
                            <span class="text-xs {{ $user->email_verified_at ? 'text-green-400' : 'text-yellow-400' }}">
                                {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection