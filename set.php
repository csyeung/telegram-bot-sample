<?php
/**
 * README
 * This file is intended to set the webhook.
 * Uncommented parameters must be filled
 */

// Load composer
require_once __DIR__ . '/vendor/autoload.php';

// Add you bot's API key and name
$bot_api_key  = '668843677:AAF4DxoJx65nodNkqKhniXZYTvv7ljSuZGw';
$bot_username = 'hknc_bot';

// Define the URL to your hook.php file
//$hook_url     = 'https://hknc-ban-bot-production.herokuapp.com/random/e714342/hook.php';
$hook_url     = 'https://hknc-ban-bot-production.herokuapp.com/personal.php';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Set webhook
    $result = $telegram->setWebhook($hook_url);
    // $result = $telegram->setWebhook($hook_url, ['certificate' => './hkncbot.pem']);

    // To use a self-signed certificate, use this line instead
    //$result = $telegram->setWebhook($hook_url, ['certificate' => $certificate_path]);

    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}
