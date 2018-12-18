<?php
/**
 * README
 * This configuration file is intended to run the bot with the webhook method.
 * Uncommented parameters must be filled
 *
 * Please note that if you open this file with your browser you'll get the "Input is empty!" Exception.
 * This is a normal behaviour because this address has to be reached only by the Telegram servers.
 */

// Load composer
require_once __DIR__ . '/vendor/autoload.php';

// Add you bot's API key and name
$bot_api_key  = '668843677:AAF4DxoJx65nodNkqKhniXZYTvv7ljSuZGw';
$bot_username = 'hknc_bot';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Enable admin users
    $telegram->enableAdmin('158208524')

    // Set custom Upload and Download paths
    //$telegram->setDownloadPath(__DIR__ . '/Download');
    //$telegram->setUploadPath(__DIR__ . '/Upload');

    // Here you can set some command specific parameters
    // e.g. Google geocode/timezone api key for /date command
    //$telegram->setCommandConfig('date', ['google_api_key' => 'your_google_api_key_here']);

    // Requests Limiter (tries to prevent reaching Telegram API limits)
    $telegram->enableLimiter();

    // Handle telegram webhook request
    $input = Request::getInput();

    if (empty($input)) {
      throw new TelegramException('Input is empty!');
    }

    $post = json_decode($input, true);
    if (empty($post)) {
        throw new TelegramException('Invalid JSON!');
    }

    $update = new Update($post, $this->bot_username);
    $update_type = $update->getUpdateType();

    if ($update_type === 'message') {
      $message = $update->getMessage();
      $type = $message->getType();

      if ($type === 'command') {

      } elseif ($type === 'new_chat_members') {

      } else {
        $chat_id = $message->getChat()->getId();
        $text    = 'Hi there!' . PHP_EOL . 'Type /help to see all commands!';

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        Request::sendMessage($data);
      }
    } else {
      $message = $update->getMessage();

      $chat_id = $message->getChat()->getId();
      $text    = 'Hi there!' . PHP_EOL . 'Type /help to see all commands!';

      $data = [
          'chat_id' => $chat_id,
          'text'    => $text,
      ];

      Request::sendMessage($data);
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    //echo $e;
    // Log telegram errors
    Longman\TelegramBot\TelegramLog::error($e);
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    // Silence is golden!
    // Uncomment this to catch log initialisation errors
    //echo $e;
}
?>
