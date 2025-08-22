<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-xl font-semibold mb-4 text-emerald-700">Data User</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Username</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No. HP</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Role</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Last Login</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($userList as $userItem)
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $userItem->username }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $userItem->email }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $userItem->phone ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800 capitalize">{{ $userItem->role }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        {{ $userItem->last_login ? \Carbon\Carbon::parse($userItem->last_login)->format('d-m-Y H:i') :
                        '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 px-4 py-4">
                        Belum ada data user.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>