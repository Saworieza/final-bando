<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-700 mb-6">Welcome, {{ Auth::user()->name }}</p>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Pending Approvals --}}
            @php
                $pendingUsers = \App\Models\User::role(['Pending Seller', 'Pending Support'])->get();
            @endphp

            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 mb-6">
                <p class="font-semibold">{{ $pendingUsers->count() }} user(s) awaiting approval</p>
            </div>

            <div class="overflow-x-auto bg-white shadow rounded mb-10">
                <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Name</th>
                            <th class="px-4 py-2 font-semibold">Email</th>
                            <th class="px-4 py-2 font-semibold">Status</th>
                            <th class="px-4 py-2 font-semibold">Change Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingUsers as $user)
                            <tr class="border-t border-gray-200">
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    {{-- Approve --}}
                                    <form method="POST" action="{{ route('admin.approve', $user->id) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="new_role" value="{{ $user->hasRole('Pending Seller') ? 'Seller' : 'Support Agent' }}">
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>

                                    {{-- Decline --}}
                                    <form method="POST" action="{{ route('admin.approve', $user->id) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="new_role" value="Buyer">
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Decline
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('admin.approve', $user->id) }}" class="flex space-x-2 items-center">
                                        @csrf
                                        @method('PATCH')
                                        <select name="new_role" class="border p-1 rounded">
                                            <option value="Seller">Seller</option>
                                            <option value="Support Agent">Support Agent</option>
                                            <option value="Buyer">Buyer</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Change
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center px-4 py-4 text-gray-500">No pending approvals.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tabbed Table for All Users --}}
            @php
                $tabs = ['Buyer', 'Seller', 'Support Agent'];
                $selectedTab = request('tab', 'Buyer');
            @endphp

            <div class="mb-4 flex space-x-4">
                @foreach ($tabs as $tab)
                    <a href="{{ route('dashboard', ['tab' => $tab]) }}"
                        class="px-4 py-2 rounded-t {{ $selectedTab === $tab ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $tab }}s
                    </a>
                @endforeach
            </div>

            @php
                $users = \App\Models\User::role($selectedTab)->get();
            @endphp

            <div class="overflow-x-auto bg-white shadow rounded">
                <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Name</th>
                            <th class="px-4 py-2 font-semibold">Email</th>
                            <th class="px-4 py-2 font-semibold">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-t border-gray-200">
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">{{ $user->getRoleNames()->first() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center px-4 py-4 text-gray-500">No {{ $selectedTab }}s found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
