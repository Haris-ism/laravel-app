<x-layout title="Admin">
    <div class="max-w-4xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-8">Admin — Users</h1>

        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-100">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :pagination="$users" :live="false"/>
    </div>

</x-layout>
