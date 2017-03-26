<?php

/**
 * Api.php
 * Created for weather
 * 2017-03-11
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\telegrambot;

use app\components\telegrambot\Commands\AbstractCommand;
use app\components\telegrambot\Commands\CommandBus;
use app\components\telegrambot\Commands\CommandInterface;
use app\components\telegrambot\Exceptions\TelegramSDKException;
use app\components\telegrambot\HttpClients\GuzzleHttpClient;
use app\components\telegrambot\HttpClients\HttpClientInterface;
use app\components\telegrambot\Keyboard\KeyboardTrait;
use app\components\telegrambot\Objects\Update;
use app\components\telegrambot\Resources\ResourceCreatorTrait;
use app\models\User;
use Illuminate\Contracts\Container\Container;
use yii\base\Component;

/**
 * Class Api
 * @package app\components\telegrambot
 */
class Api extends Component
{
    use SenderTrait, KeyboardTrait, ResourceCreatorTrait {
        KeyboardTrait::init as private keyboardInit;
    }

    /** @var null|string|HttpClientInterface (Optional) Custom HTTP Client Handler. */
    public $httpClientHandler = null;

    /** @var string Telegram Bot API Access Token. */
    public $accessToken = null;

    /** @var string */
    public $commandPath = null;

    /** @var bool|null */
    public $lastExecuteStatus = null;

    /** @var CommandBus|null Telegram Command Bus. */
    protected $commandBus = null;

    /** @var TelegramClient The Telegram client service. */
    protected $client;

    /** @var  User */
    protected $user;

    /** @var bool Indicates if the request to Telegram will be asynchronous (non-blocking). */
    protected $isAsyncRequest = false;

    /**
     * Timeout of the request in seconds.
     * @var int
     */
    protected $timeOut = 60;

    /**
     * Connection timeout of the request in seconds.
     * @var int
     */
    protected $connectTimeOut = 10;

    /** @var Container IoC Container */
    protected static $container = null;

    /** @var Update */
    private $_update = null;

    /**
     * Instantiates a new Telegram super-class object.
     * @throws \app\components\telegrambot\Exceptions\TelegramSDKException
     */
    public function init()
    {
        if (!$this->accessToken) {
            throw new TelegramSDKException('Required "accessToken" not supplied in config');
        }
        if (!$this->commandPath) {
            throw new TelegramSDKException('Required "commandPath" not supplied in config');
        }

        $httpClientHandler = null;
        if (isset($this->httpClientHandler)) {
            if ($this->httpClientHandler instanceof HttpClientInterface) {
                $httpClientHandler = $this->httpClientHandler;
            } elseif ($this->httpClientHandler === 'guzzle') {
                $httpClientHandler = new GuzzleHttpClient();
            } else {
                throw new \InvalidArgumentException('The HTTP Client Handler must be set to "guzzle", or be an instance of app\components\telegrambot\HttpClients\HttpClientInterface');
            }
        }

        $this->client = new TelegramClient($httpClientHandler);

        $this->_loadCommands();
        $this->keyboardInit();
        parent::init();
    }

    /**
     * @return \app\components\telegrambot\Objects\Update
     */
    public function commandsHandler()
    {
        $update = $this->getWebhookUpdates();
        $this->processCommand($update);
        return $update;
    }

    /**
     * Add Telegram Command to the Command Bus.
     * @param CommandInterface|string $command
     * @return CommandBus
     */
    public function addCommand($command)
    {
        return $this->getCommandBus()->addCommand($command);
    }

    /**
     * Get the IoC Container.
     * @return Container
     */
    public function getContainer()
    {
        return self::$container;
    }

    /**
     * Check if IoC Container has been set.
     * @return boolean
     */
    public function hasContainer()
    {
        return self::$container !== null;
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     * @return bool
     */
    public function isAsyncRequest()
    {
        return $this->isAsyncRequest;
    }

    /**
     * Returns Telegram Bot API Access Token.
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return int
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @return int
     */
    public function getConnectTimeOut()
    {
        return $this->connectTimeOut;
    }

    /**
     * @return TelegramClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return \app\models\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \app\components\telegrambot\Objects\Update
     */
    public function getUpdate()
    {
        return $this->_update;
    }

    /**
     * @return Update
     */
    public function getWebhookUpdates()
    {
        if ($this->_update === null) {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->_update = new Update($body);
        }
        $this->afterGetWebhookUpdates();
        return $this->_update;
    }

    protected function afterGetWebhookUpdates()
    {
        if (isset($this->_update)) {
            $message = $this->_update->getMessage();
            if (isset($message)) {
                $this->user = User::getUser($this->_update->getMessage()->getFrom());
            }
        }
    }

    /**
     * @param \app\components\telegrambot\Objects\Update $update
     * @return \app\components\telegrambot\Objects\Update|null
     */
    protected function processCommand(Update $update)
    {
        $message = $update->getMessage();
        $command = null;
        $result = null;

        if ($message !== null) {
            if ($message->has('text')) {
                $command = $message->getText();
            }
////            } elseif ($message->has('location')) {
////                $command = '/' . AbstractCommand::COMMAND_LOCATION;
////            }
        }

        if ($command !== null) {
            $result = $this->getCommandBus()->handler($command, $update);
        }

        return $result;
    }

    /**
     * Returns Command Bus.
     * @return CommandBus
     */
    protected function getCommandBus()
    {
        if (is_null($this->commandBus)) {
            return $this->commandBus = new CommandBus($this);
        }

        return $this->commandBus;
    }

    /**
     * Load commands automatically
     */
    private function _loadCommands()
    {
        $this->_loadResource(AbstractCommand::COMMAND, $this->commandPath, 'addCommand');
    }
}
