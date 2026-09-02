<x-sidebar-layout title="{{ $message->subject }}">
<div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-4 pb-4 border-b">
                    <p class="text-sm text-gray-500">
                        De : <span class="font-medium text-gray-900">{{ $message->sender->name ?? 'Compte supprimé' }}</span>
                    </p>
                    <p class="text-sm text-gray-500">
                        À : <span class="font-medium text-gray-900">{{ $message->recipient->name ?? 'Compte supprimé' }}</span>
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $message->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>

                <div class="prose max-w-none">
                    {{ $message->body }}
                </div>

                <div class="mt-6 pt-4 border-t">
                    <a href="{{ route('messages.index') }}" class="text-gray-600">← Retour à la messagerie</a>
                </div>

            </div>
        </div>
    </div>
</x-sidebar-layout>
