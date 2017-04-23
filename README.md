# Init
1. Create a bot (use `BotFather` bot and `/newbot` command)
2. Register bot in `BotanioBot`
3. `composer install`
4. Set up web server or run `php yii serve`
5. `./ngrok http 8080` for local environment
6.`https://api.telegram.org/bot(token)/setWebhook?url=?`

## Run tests
1. Apply migrations `./tests/bin/yii migrate up
`
2. Run unit tests `php vendor/bin/codecept run unit`

**Project is based on [Telegram Bot API PHP SDK](https://github.com/irazasyed/telegram-bot-sdk)**
