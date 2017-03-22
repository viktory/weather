<?php

namespace app\components\telegrambot\Commands;

use app\components\telegrambot\Api;
use app\components\telegrambot\Exceptions\TelegramSDKException;
use app\components\telegrambot\Objects\Update;

/**
 * Class AbstractCommand
 * @package app\components\telegrambot\Commands
 *  * @method mixed replyWithMessage($use_sendMessage_parameters) Reply Chat with a message. You can use all the sendMessage() parameters except chat_id.
 * @method mixed replyWithPhoto($use_sendPhoto_parameters) Reply Chat with a Photo. You can use all the sendPhoto()
 * parameters except chat_id.
 * @method mixed replyWithAudio($use_sendAudio_parameters) Reply Chat with an Audio message. You can use all the
 * sendAudio() parameters except chat_id.
 * @method mixed replyWithVideo($use_sendVideo_parameters) Reply Chat with a Video. You can use all the sendVideo()
 * parameters except chat_id.
 * @method mixed replyWithVoice($use_sendVoice_parameters) Reply Chat with a Voice message. You can use all the
 * sendVoice() parameters except chat_id.
 * @method mixed replyWithDocument($use_sendDocument_parameters) Reply Chat with a Document. You can use all the sendDocument() parameters except chat_id.
 * @method mixed replyWithSticker($use_sendSticker_parameters) Reply Chat with a Sticker. You can use all the
 * sendSticker() parameters except chat_id.
 * @method mixed replyWithLocation($use_sendLocation_parameters) Reply Chat with a Location. You can use all the sendLocation() parameters except chat_id.
 * @method mixed replyWithChatAction($use_sendChatAction_parameters) Reply Chat with a Chat Action. You can use all the sendChatAction() parameters except chat_id.
 */
abstract class AbstractCommand implements CommandInterface
{
    const COMMAND = 'Command';
    //todo move constants to somewhere else. avoid to create command as '/'.constant
    const COMMAND_ERROR = 'error';
//    const COMMAND_START = 'start';
//    const COMMAND_HELP = 'help';
//    const COMMAND_LOCATION = 'saveLocation';

    /**
     * The name of the Telegram command.
     * Ex: help - Whenever the user sends /help, this would be resolved.
     * @var string
     */
    protected $name;

    /** @var string The Telegram command description. */
    protected $description;

    /**  @var Api Holds the Super Class Instance. */
    protected $telegram;

    /** @var string Arguments passed to the command. */
    protected $arguments;

    /** @var Update Holds an Update object. */
    protected $update;

    /**
     * AbstractCommand constructor.
     * @throws \app\components\telegrambot\Exceptions\TelegramSDKException
     */
    public function __construct()
    {
        if (!isset($this->name)) {
            $reflect = new \ReflectionClass($this);
            $className = $reflect->getShortName();
            if (substr($className, -7) !== self::COMMAND) {
                throw new TelegramSDKException(get_class($this) . ' must have a $name');
            }
            $this->name = lcfirst(rtrim($className, self::COMMAND));
        }
    }

    /**
     * Get Command Name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Command Name in lower case
     * @return string
     */
    public function getLowerName()
    {
        return strtolower($this->name);
    }

    /**
     * Set Command Name.
     * @param string $name
     * @return AbstractCommand
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Command Description.
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Command Description.
     * @param string $description
     * @return AbstractCommand
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->description;
    }

    /**
     * Returns Telegram Instance.
     * @return Api
     */
    public function getTelegram()
    {
        return $this->telegram;
    }

    /**
     * Returns Original Update.
     * @return Update
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * Get Arguments passed to the command.
     * @return string
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->telegram->getUser()->first_name;
    }

    /**
     * @return string
     */
    public static function getErrorCommand()
    {
        return '/' . self::COMMAND_ERROR;
    }

    /**
     * {@inheritdoc}
     */
    public function make(Api $telegram, array $arguments, Update $update, array $keyboard = [])
    {
        $this->telegram = $telegram;
        $this->arguments = $arguments;
        $this->update = $update;

        if ($this->beforeHandle($arguments)) {
            $result = $this->handle($arguments);
            return $this->afterHandle($result);
        }

        return false;
    }

    /**
     * @param array $arguments
     * @return bool
     */
    protected function beforeHandle(array $arguments)
    {
        return true;
    }

    /**
     * @param $result
     * @return mixed
     */
    protected function afterHandle($result)
    {
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function handle(array $arguments);

    /**
     * Magic Method to handle all ReplyWith Methods.
     * @param $method
     * @param $arguments
     * @return mixed|string
     */
    public function __call($method, $arguments)
    {
        $action = substr($method, 0, 9);
        if ($action === 'replyWith') {
            $reply_name = substr($method, 9);
            $methodName = 'send' . $reply_name;

            if (!method_exists($this->telegram, $methodName)) {
                return 'Method Not Found';
            }

            $chat_id = $this->update->getChatId();
            $params = array_merge(compact('chat_id'), $arguments[0], []);

            return call_user_func_array([$this->telegram, $methodName], [$params]);
        }

        return 'Method Not Found';
    }
}
