<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Chat WebSocket</h1>
                        <p class="text-sm text-slate-500">Canal público: <span class="font-medium">chat</span></p>
                    </div>
                    <span id="connection-status" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">conectando...</span>
                </div>
                <div id="messages" class="h-[28rem] space-y-3 overflow-y-auto bg-slate-50 p-6">
                    @forelse ($messages as $message)
                        <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $message->id }}">
                            <div class="max-w-[80%] rounded-2xl {{ $message->user_id === auth()->id() ? 'rounded-br-sm bg-indigo-600 text-white' : 'rounded-bl-sm bg-white text-slate-800 ring-1 ring-slate-200' }} px-4 py-3 shadow-sm">
                                <div class="mb-1 text-xs font-bold opacity-70">{{ $message->user->name }}</div>
                                <div class="break-words text-sm">{{ $message->body }}</div>
                                <div class="mt-1 text-right text-[10px] opacity-60">{{ $message->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div id="empty-state" class="flex h-full items-center justify-center text-sm text-slate-400">Nenhuma mensagem ainda. Seja o primeiro a escrever.</div>
                    @endforelse
                </div>
                <form id="message-form" method="POST" action="{{ route('chat.store') }}" class="flex gap-3 border-t border-slate-100 p-5">
                    @csrf
                    <input id="message-input" name="body" required maxlength="1000" autocomplete="off" placeholder="Digite sua mensagem..." class="flex-1 rounded-xl border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 active:scale-95">Enviar</button>
                </form>
                @error('body') <p class="px-5 pb-4 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <p class="mt-4 text-center text-xs text-slate-400">Logado como {{ auth()->user()->name }} · Abra outra janela para testar dois usuários.</p>
        </div>
    </div>
</x-app-layout>
