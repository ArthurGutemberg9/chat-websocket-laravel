# Requisitos extraídos do Tutorial-ChatLaravel.pdf

O tutorial propõe: criar um projeto Laravel; configurar banco `chatweb3ams`; instalar Laravel Breeze para perfis/autenticação; executar migrations e assets; instalar Chatify; criar app/canal no Pusher (cluster us2), configurar variáveis Pusher no `.env`; executar `npm run dev` e `php artisan serve`; testar com duas contas para simular conversa.

Adaptação implementada neste projeto: Laravel Breeze para autenticação e Laravel Reverb como servidor WebSocket self-hosted, evitando expor chaves do Pusher. A arquitetura mantém os objetivos do tutorial (autenticação, banco, canal em tempo real e teste com dois usuários), mas usa uma solução oficial atual do ecossistema Laravel. O README explica a diferença e também registra a alternativa Pusher.

Fonte: /home/ubuntu/upload/Tutorial-ChatLaravel.pdf, páginas 1–5.
