<?php
/**
 * SenderTrait.php
 * Created for weather
 * 2017-03-11
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\telegrambot;

use app\components\telegrambot\Exceptions\TelegramSDKException;
use app\components\telegrambot\FileUpload\InputFile;
use app\components\telegrambot\Objects\Message;

/**
 * Trait SenderTrait
 * @package app\components\telegrambot
 */
trait SenderTrait
{
    /**
     * @var TelegramResponse|null Stores the last request made to Telegram Bot API.
     */
    protected $lastResponse;

    /**
     * Send text messages.
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'reply_to_message_id'      => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var string     $params ['text']
     * @var string     $params ['parse_mode']
     * @var bool       $params ['disable_web_page_preview']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     * @return Message
     */
    public function sendMessage(array $params)
    {
        $response = $this->post('sendMessage', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Send Photos.
     *
     * <code>
     * $params = [
     *   'chat_id'             => '',
     *   'photo'               => '',
     *   'caption'             => '',
     *   'reply_to_message_id' => '',
     *   'reply_markup'        => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var string     $params ['photo']
     * @var string     $params ['caption']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     * @return Message
     */
    public function sendPhoto(array $params)
    {
        return $this->uploadFile('sendPhoto', $params);
    }

    /**
     * Send regular audio files.
     *
     * <code>
     * $params = [
     *   'chat_id'             => '',
     *   'audio'               => '',
     *   'duration'            => '',
     *   'performer'           => '',
     *   'title'               => '',
     *   'reply_to_message_id' => '',
     *   'reply_markup'        => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var string     $params ['audio']
     * @var int        $params ['duration']
     * @var string     $params ['performer']
     * @var string     $params ['title']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     * @return Message
     */
    public function sendAudio(array $params)
    {
        return $this->uploadFile('sendAudio', $params);
    }

    /**
     * Send general files.
     *
     * <code>
     * $params = [
     *   'chat_id'             => '',
     *   'document'            => '',
     *   'reply_to_message_id' => '',
     *   'reply_markup'        => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#senddocument
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var string     $params ['document']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     * @return Message
     */
    public function sendDocument(array $params)
    {
        return $this->uploadFile('sendDocument', $params);
    }

    /**
     * Send .webp stickers.
     *
     * <code>
     * $params = [
     *   'chat_id' => '',
     *   'sticker' => '',
     *   'reply_to_message_id' => '',
     *   'reply_markup' => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var string     $params ['sticker']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     * @throws TelegramSDKException
     * @return Message
     */
    public function sendSticker(array $params)
    {
        if (is_file($params['sticker']) && (pathinfo($params['sticker'], PATHINFO_EXTENSION) !== 'webp')) {
            throw new TelegramSDKException('Invalid Sticker Provided. Supported Format: Webp');
        }

        return $this->uploadFile('sendSticker', $params);
    }

    /**
     * Send Video File, Telegram clients support mp4 videos (other formats may be sent as Document).
     *
     * <code>
     * $params = [
     *   'chat_id'             => '',
     *   'video'               => '',
     *   'duration'            => '',
     *   'caption'             => '',
     *   'reply_to_message_id' => '',
     *   'reply_markup'        => '',
     * ];
     * </code>
     *
     * @see  sendDocument
     * @link https://core.telegram.org/bots/api#sendvideo
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var string     $params ['video']
     * @var int        $params ['duration']
     * @var string     $params ['caption']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     * @return Message
     */
    public function sendVideo(array $params)
    {
        return $this->uploadFile('sendVideo', $params);
    }

    /**
     * Send voice audio files.
     *
     * <code>
     * $params = [
     *   'chat_id'             => '',
     *   'voice'               => '',
     *   'duration'            => '',
     *   'reply_to_message_id' => '',
     *   'reply_markup'        => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var string     $params ['voice']
     * @var int        $params ['duration']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     * @return Message
     */
    public function sendVoice(array $params)
    {
        return $this->uploadFile('sendVoice', $params);
    }

    /**
     * Send point on the map.
     *
     * <code>
     * $params = [
     *   'chat_id'             => '',
     *   'latitude'            => '',
     *   'longitude'           => '',
     *   'reply_to_message_id' => '',
     *   'reply_markup'        => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var float      $params ['latitude']
     * @var float      $params ['longitude']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     * @return Message
     */
    public function sendLocation(array $params)
    {
        $response = $this->post('sendLocation', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Broadcast a Chat Action.
     *
     * <code>
     * $params = [
     *   'chat_id' => '',
     *   'action'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendchataction
     * @param array    $params
     * @var int|string $params ['chat_id']
     * @var string     $params ['action']
     * @throws TelegramSDKException
     * @return TelegramResponse
     */
    public function sendChatAction(array $params)
    {
        $validActions = [
            'typing',
            'upload_photo',
            'record_video',
            'upload_video',
            'record_audio',
            'upload_audio',
            'upload_document',
            'find_location',
        ];

        if (isset($params['action']) && in_array($params['action'], $validActions)) {
            return $this->post('sendChatAction', $params);
        }

        throw new TelegramSDKException('Invalid Action! Accepted value: '.implode(', ', $validActions));
    }

    /**
     * Sends a multipart/form-data request to Telegram Bot API and returns the result.
     * Used primarily for file uploads.
     * @param string $endpoint
     * @param array  $params
     * @throws TelegramSDKException
     * @return Message
     */
    protected function uploadFile($endpoint, array $params = [])
    {
        $i = 0;
        $multipart_params = [];
        foreach ($params as $name => $contents) {
            if (is_null($contents)) {
                continue;
            }

            if (!is_resource($contents) && $name !== 'url') {
                $validUrl = filter_var($contents, FILTER_VALIDATE_URL);
                $contents = (is_file($contents) || $validUrl) ? (new InputFile($contents))->open() : (string)$contents;
            }

            $multipart_params[$i]['name'] = $name;
            $multipart_params[$i]['contents'] = $contents;
            ++$i;
        }

        $response = $this->post($endpoint, $multipart_params, true);

        return new Message($response->getDecodedBody());
    }

    /**
     * Sends a POST request to Telegram Bot API and returns the result.
     * @param string $endpoint
     * @param array  $params
     * @param bool   $fileUpload Set true if a file is being uploaded.
     * @return TelegramResponse
     */
    protected function post($endpoint, array $params = [], $fileUpload = false)
    {
        if ($fileUpload) {
            $params = ['multipart' => $params];
        } else {
            $params = ['form_params' => $params];
        }

        return $this->sendRequest(
            'POST',
            $endpoint,
            $params
        );
    }

    /**
     * Sends a request to Telegram Bot API and returns the result.
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     * @throws TelegramSDKException
     * @return TelegramResponse
     */
    protected function sendRequest(
        $method,
        $endpoint,
        array $params = []
    ) {
        $request = $this->request($method, $endpoint, $params);
        /** @var TelegramClient $client */
        $client = $this->getClient();
        return $this->lastResponse = $client->sendRequest($request);
    }

    /**
     * Instantiates a new TelegramRequest entity.
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     * @return TelegramRequest
     */
    protected function request(
        $method,
        $endpoint,
        array $params = []
    ) {
        return new TelegramRequest(
            $this->getAccessToken(),
            $method,
            $endpoint,
            $params,
            $this->isAsyncRequest(),
            $this->getTimeOut(),
            $this->getConnectTimeOut()
        );
    }
}
