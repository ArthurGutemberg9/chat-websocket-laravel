# Chat Laravel WebSocket

Projeto acadêmico de chat em tempo real desenvolvido com **Laravel**, **Laravel Breeze**, **Laravel Reverb**, **Laravel Echo**, **Vite** e **SQLite**. A aplicação permite criar contas, fazer login e conversar em um canal público: quando uma pessoa envia uma mensagem, os demais usuários conectados recebem o conteúdo sem atualizar a página.

## Relação com o tutorial da atividade

O tutorial fornecido orienta a criação do projeto Laravel, a configuração do banco, a instalação do Breeze, a execução das migrations e a utilização de um serviço de canais em tempo real, com teste por meio de duas contas. Este projeto segue esses objetivos. Em vez de depender de uma conta externa do Pusher ou do pacote Chatify, foi utilizado o **Laravel Reverb**, servidor WebSocket oficial do ecossistema Laravel, executado localmente e configurado com o canal `chat`. Isso deixa a demonstração reproduzível e não exige publicar chaves secretas no repositório.

## Funcionalidades

- Cadastro, login, logout e edição de perfil com Laravel Breeze.
- Persistência de mensagens na tabela `messages`.
- Histórico das últimas 100 mensagens.
- Broadcast do evento `MessageSent` no canal público `chat`.
- Atualização instantânea no navegador usando Laravel Echo e Pusher JS.
- Interface responsiva e indicação visual do estado da conexão.

## Requisitos

PHP 8.2+, Composer, Node.js 20+, npm e SQLite. Para usar MySQL, altere as variáveis `DB_*` no `.env` e crie um banco chamado `chatweb3ams`, como no tutorial.

## Instalação

```bash
git clone URL_DO_REPOSITORIO
cd chat-websocket
composer install
cp .env.example .env
php artisan key:generate
npm install
php artisan migrate
npm run build
```

O instalador do Reverb cria as variáveis locais no `.env`. Para conferir a configuração mínima, o ambiente deve conter:

```dotenv
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=local-chat
REVERB_APP_KEY=local-chat-key
REVERB_APP_SECRET=local-chat-secret
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
REVERB_SCHEME=http
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

## Executar em desenvolvimento

Abra três terminais dentro do projeto:

```bash
# Terminal 1: servidor Laravel
php artisan serve

# Terminal 2: servidor WebSocket
php artisan reverb:start

# Terminal 3: compilador Vite em modo desenvolvimento
npm run dev
```

Acesse `http://127.0.0.1:8000`, crie duas contas em janelas diferentes e envie mensagens. A confirmação da atividade acontece quando a mensagem enviada em uma janela aparece na outra sem refresh. Para visualizar o código, os arquivos principais são `app/Events/MessageSent.php`, `app/Http/Controllers/ChatController.php`, `resources/js/app.js`, `resources/views/chat/index.blade.php` e a migration em `database/migrations`.

## Como funciona

1. O usuário envia o formulário para `POST /chat/messages`.
2. O controller valida o texto e salva a mensagem relacionada ao usuário autenticado.
3. O evento `MessageSent` é transmitido no canal público `chat`.
4. O Laravel Reverb mantém a conexão WebSocket persistente.
5. O Laravel Echo escuta `.message.sent` e cria a nova mensagem na tela dos clientes conectados.
6. `toOthers()` evita duplicar a mensagem na janela que acabou de enviá-la; o histórico continua persistido no banco.

## Roteiro curto para o vídeo

1. Apresente o objetivo: chat com comunicação bidirecional e sem atualização manual.
2. Mostre `composer.json` com Breeze e Reverb e o `.env` sem exibir segredos reais.
3. Mostre a migration `messages`, o model `Message` e o relacionamento com `User`.
4. Mostre o evento `MessageSent` e destaque `ShouldBroadcast` e o canal `chat`.
5. Mostre o `ChatController` salvando a mensagem e usando `broadcast(...)->toOthers()`.
6. Mostre `resources/js/app.js`, destacando `Echo.channel('chat')` e `.listen('.message.sent')`.
7. Execute os três comandos (`php artisan serve`, `php artisan reverb:start`, `npm run dev`).
8. Abra duas janelas, cadastre dois usuários e demonstre mensagens nos dois lados sem recarregar a página.
9. Finalize mostrando o README e o repositório GitHub.

Fale com suas próprias palavras: explique que HTTP normalmente trabalha em requisição e resposta, enquanto o WebSocket mantém uma conexão aberta para que o servidor publique eventos assim que eles acontecem. Não declare que foi usado Pusher se a configuração demonstrada for Reverb.

## Testes rápidos

```bash
php artisan test
php artisan route:list --path=chat
npm run build
```

## Segurança e publicação

O arquivo `.env` não deve ser enviado ao GitHub. Use `.env.example` como modelo e nunca publique senhas, chaves privadas ou credenciais de serviços externos. Para produção, use HTTPS/WSS, um banco gerenciado e um processo persistente para o Reverb.

## Créditos

Implementação acadêmica baseada no tutorial `Tutorial-ChatLaravel.pdf` fornecido na atividade e na documentação oficial do [Laravel Broadcasting](https://laravel.com/docs/broadcasting), [Laravel Reverb](https://laravel.com/docs/reverb) e [Laravel Breeze](https://laravel.com/docs/starter-kits).
