

import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Alpine = Alpine;

Alpine.start();

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

const status = document.getElementById('connection-status');
const messages = document.getElementById('messages');
const form = document.getElementById('message-form');
const input = document.getElementById('message-input');

if (status && messages && form && input) {
    window.Echo.channel('chat')
        .subscribed(() => {
            status.textContent = 'conectado';
            status.className = 'rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700';
        })
        .error(() => {
            status.textContent = 'offline';
            status.className = 'rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700';
        })
        .listen('.message.sent', (message) => {
            const empty = document.getElementById('empty-state');
            if (empty) empty.remove();
            const wrapper = document.createElement('div');
            wrapper.className = 'flex justify-start';
            wrapper.dataset.messageId = message.id;
            wrapper.innerHTML = `<div class="max-w-[80%] rounded-2xl rounded-bl-sm bg-white text-slate-800 ring-1 ring-slate-200 px-4 py-3 shadow-sm"><div class="mb-1 text-xs font-bold opacity-70"></div><div class="break-words text-sm"></div><div class="mt-1 text-right text-[10px] opacity-60">agora</div></div>`;
            wrapper.querySelector('.font-bold').textContent = message.user;
            wrapper.querySelector('.text-sm').textContent = message.body;
            messages.appendChild(wrapper);
            messages.scrollTop = messages.scrollHeight;
        });

    form.addEventListener('submit', () => {
        setTimeout(() => { input.value = ''; input.focus(); }, 0);
    });
    messages.scrollTop = messages.scrollHeight;
}
