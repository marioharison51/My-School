<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Messagerie
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">
                <a href="{{ route('messages.create') }}" class="px-4 py-2 bg-primary-700 hover:bg-primary-600 text-white rounded">
                    + Nouveau message
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 px-4">De</th>
                            <th class="py-2 px-4">Sujet</th>
                            <th class="py-2 px-4">Date</th>
                            <th class="py-2 px-4">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($received as $message)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4">
                                    <a href="{{ route('messages.show', $message) }}" class="text-primary-700">
                                        {{ $message->sender->name }}
                                    </a>
                                </td>
                                <td class="py-2 px-4">{{ $message->subject }}</td>
                                <td class="py-2 px-4">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-2 px-4">
                                    @if ($message->read_at)
                                        <span class="text-gray-400">Lu</span>
                                    @else
                                        <span class="font-semibold text-gray-900">Non lu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 px-4 text-gray-500">Aucun message reçu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
